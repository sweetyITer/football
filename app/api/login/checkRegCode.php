<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/20
 * Time: 15:16
 */
namespace app\api\login;

use app\AppApi;
use model\entity\UserSign;

class checkRegCode extends AppApi
{
    protected $phone;
    protected $code;

    protected function init()
    {
        $this->addParams(['phone', 'code']);
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        $userSignObj = new UserSign();
        $userSignObj->checkVerify($this->phone, $this->code, $type = "reg", 60);
    }
}