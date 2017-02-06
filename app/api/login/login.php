<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/12
 * Time: 13:59
 */
namespace app\api\Login;
use app\AppApi;
use mmapi\core\AppException;
use model\entity\User;

class login extends AppApi
{
    protected $phone;
    protected $password;

    protected function init()
    {
        $this->addParams(['phone', 'password']);
        $this->get('auth')->setRequire(false);
    }

    /**
     * run @desc 资讯列表
     *
     * @author wangjuan
     */
    public function run()
    {
        //检测是手机号
        if(preg_match('^((\\+86)|(86))?[1][3456789][0-9]{9}$', $this->phone, $match)){
           $this->set('data', $match);
        }
        //检测用户是否存在
        $user_id = User::getIdByPhone($this->phone);
        if($user_id <= 0){
            throw new AppException('用户名不存在');
        }
        //检测密码是否正确
        /** @var User $userObj */
        $userObj = User::getInstance($user_id);

        //检测用户的密码是否正确
        if(!$userObj->checkPassword($this->password)) {
            throw new AppException('密码错误');
        }

        setcookie("uid", $user_id, time() + 3600 * 2, '/');
        setcookie("auth", $userObj->getAuth(), time() + 3600 * 24 * 60, '/');
    }
}