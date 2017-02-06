<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/12
 * Time: 14:14
 */
namespace app\api\login;

use app\AppApi;
use mmapi\api\ApiException;
use model\entity\User;

class register extends AppApi
{
    protected $phone;
    protected $password;
    protected $againPassword;
    protected $userName;
    protected $email;
    protected $nickName;

    protected function init()
    {
        $this->addParams(['phone', 'password', 'againPassword', 'userName', 'email', 'nickName']);
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        if ($this->password !== $this->againPassword) {
            throw new ApiException('俩次输入密码不一样', 'PASSWORD_NOT_SAME');
        }
        $userObj = new User();
        if ($userObj->checkNameRepeat($this->userName) != null) {
            throw new ApiException('用户名已经存在', 'USERNAME_EXIST');
        }
        $userObj
            ->setGuid("1234")
            ->setLastIp("1")
            ->setPhone($this->phone)
            ->setPassword($this->password)
            ->setNickName($this->nickName)
            ->setUserName($this->userName)
            ->setEmail($this->email)
            ->save();

    }
}