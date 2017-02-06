<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/17
 * Time: 11:16
 */

namespace mmapi\api;

use mmapi\core\Api;
use mmapi\core\Cache;

abstract class DenyResubmitApi extends Api
{
    //阻止重复提交表单 默认关闭 false
    //key :阻止重复提交的唯一key 为null则对当前请求url进行hash
    //expire: 阻止重复提交的最大有效期 超过有效期则自动失效 默认2s
    //code：当验证是重复提交时 产生的错误码
    //msg:当验证是重复提交时 提交文字内容
    //cache_key_suffix:队列缓存key前缀 默认 deny_resubmit_
    // ['key'    => null,'expire' => 2,'code'   => 'SYSTEM_BUSY','msg'    => '系统正在处理中...']
    const OPT_DENY_RESUBMIT = 'deny_resubmit';

    public function __construct()
    {
        $this->option(self::OPT_DENY_RESUBMIT, false);
        parent::__construct();
    }

    protected function beforeRun()
    {
        parent::beforeRun();
        //检查是否重复提交
        $this->checkResubmit();
    }

    /**
     * @desc   setDenyResubmitKey 设置防止重复提交的唯一key
     * @author chenmingming
     *
     * @param array  $params 参与的key
     * @param string $suffix 前缀
     */
    protected function setDenyResubmitKey(array $params = [], $suffix = '')
    {
        $this->initResubmit();
        $this->options[self::OPT_DENY_RESUBMIT]['key_params'] = $params;
        $this->options[self::OPT_DENY_RESUBMIT]['key_suffix'] = $suffix;
    }

    /**
     * @desc   getDenyResubmitKey 获取key
     * @author chenmingming
     * @return string
     */
    protected function getDenyResubmitKey()
    {
        if ($this->options[self::OPT_DENY_RESUBMIT]) {
            if ($this->options[self::OPT_DENY_RESUBMIT]['key'] === null) {
                $keyArray = [];
                if ($this->options[self::OPT_DENY_RESUBMIT]['key_params']) {
                    foreach ($this->options[self::OPT_DENY_RESUBMIT]['key_params'] as $param) {
                        $apiParam = $this->get($param);
                        if ($apiParam && is_string($apiParam->getValue())) {
                            $keyArray[] = $apiParam->getValue();
                        }
                    }
                } else {
                    $keyArray = [
                        $_SERVER['REQUEST_URI'],
                        $_SERVER['HTTP_COOKIE'],
                    ];
                }

                $keyStr                                        = $this->options[self::OPT_DENY_RESUBMIT]['key_suffix'] . implode('-', $keyArray);
                $this->options[self::OPT_DENY_RESUBMIT]['key'] =
                    $this->options[self::OPT_DENY_RESUBMIT]['cache_key_pre']
                    . md5($keyStr);

                $this->debug('deny_key_str', $keyStr);
                $this->debug('deny_key', $this->options[self::OPT_DENY_RESUBMIT]['key']);
            }

            return $this->options[self::OPT_DENY_RESUBMIT]['key'];

        } else {
            return '';
        }
    }

    /**
     * @desc   finishSubmit 清除重复提交验证
     * @author chenmingming
     */
    protected function finishSubmit()
    {
        if ($this->options[self::OPT_DENY_RESUBMIT]) {
            if ($this->return['code'] != $this->options[self::OPT_DENY_RESUBMIT]['code'])
                //如果开始了重复提交 则业务正常结束后删除key
                Cache::rm($this->getDenyResubmitKey());
        }
    }

    /**
     * @desc   checkResubmit 检查是否重复提交
     * @author chenmingming
     * @throws ApiException
     */
    protected function checkResubmit()
    {
        if ($this->options[self::OPT_DENY_RESUBMIT]) {
            $this->initResubmit();
            //已经开启防止重复提交
            $queueNum = Cache::inc($this->getDenyResubmitKey(), 1, $this->options[self::OPT_DENY_RESUBMIT]['expire']);
            $this->debug('queueNum', $queueNum);
            if ($queueNum !== 1) {
                throw new ApiException(
                    $this->options[self::OPT_DENY_RESUBMIT]['msg'],
                    $this->options[self::OPT_DENY_RESUBMIT]['code']
                );
            }
        }
    }

    /**
     * @desc   initResubmit 初始化重复提交配置
     * @author chenmingming
     */
    private function initResubmit()
    {
        if (isset($this->options[self::OPT_DENY_RESUBMIT]['init'])) {
            return;
        }
        if (!is_array($this->options[self::OPT_DENY_RESUBMIT])) {
            $this->options[self::OPT_DENY_RESUBMIT] = [];
        }
        $this->options[self::OPT_DENY_RESUBMIT] = array_merge([
            'key'           => null,
            'key_params'    => [],
            'key_suffix'    => '',
            'expire'        => 2,
            'code'          => 'SYSTEM_BUSY',
            'msg'           => '系统正在处理中...',
            'cache_key_pre' => 'deny_resubmit_',
            'init'          => true,
        ], $this->options[self::OPT_DENY_RESUBMIT]);
    }

    /**
     * @desc   denyResubmit
     * @author chenmingming
     */
    protected function denyResubmit()
    {
        $this->initResubmit();
    }

    /**
     * @desc   afterResponse
     * @author chenmingming
     */
    protected function afterResponse()
    {
        parent::afterResponse(); // TODO: Change the autogenerated stub
        $this->finishSubmit();
    }
}