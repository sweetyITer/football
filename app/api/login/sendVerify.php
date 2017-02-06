<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/19
 * Time: 17:57
 */
namespace app\api\login;

use app\AppApi;
use mmapi\api\ApiException;
use model\entity\UserSign;
use model\entity\User;

class sendVerify extends AppApi
{
    protected $phone;
    protected $type;

    protected function init()
    {
        $this->addParams(['phone', 'type']);
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        if(User::IsPhoneExit($this->phone)){
            throw new ApiException('电话号码已经被注册','PHONE_REGISTERED');
        }
        $userSignObj = new UserSign();
        $userSignObj->sendCode($this->phone, $this->type);
    }
}