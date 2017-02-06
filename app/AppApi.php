<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/2
 * Time: 21:07
 */

namespace app;

use mmapi\api\SignApi;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use model\entity\User;
use mmapi\core\Db;

abstract class AppApi extends SignApi
{
    /** @var  User */
    protected $user;
    protected $db;

    public function __construct()
    {
        $this->db = Db::create();
        parent::__construct();
        $this->get('auth')
        && !is_null($this->get('auth')->getValue())
        && $this->user = User::getInstanceByAuth($this->get('auth')->getValue());
    }

    /**
     * @desc   makeSign 签名算法
     * @author chenmingming
     * @return string
     */
    protected function makeSign()
    {
        $data = [];
        /** @var ApiParams $param */
        foreach ($this->params as $param) {
            $param->getKey() != 'sign'
            &&
            !is_null($param->getValue())
            &&
            $data[$param->getKey()] = $param->getValue();
        }
        ksort($data);
        $signstr = '';
        foreach ($data as $k => $v) {
            $signstr .= $k . '=' . $v . '&';
        }
        $signstr .= 'key=' . $this->options[self::OPT_SECRET];
        $sign = strtoupper(substr(md5($signstr), 3, 24));
        $this->debug('sign', [
            'signstr'  => $signstr,
            'expected' => $sign,
            'actual'   => $this->get('sign')->getValue(),
        ]);

        return $sign;
    }
}