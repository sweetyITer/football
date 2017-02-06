<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/10
 * Time: 21:47
 */

namespace mmapi\wechat\core;

interface Log
{
    /**
     * @desc   log
     * @author chenmingming
     *
     * @param string $msg   日志内容
     * @param string $label 日志标签
     *
     * @return mixed
     */
    public function log($msg, $label);
}