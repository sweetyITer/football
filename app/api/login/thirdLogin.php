<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/18
 * Time: 18:09
 */
namespace app\api\login;

use app\AppApi;
use mmapi\api\ApiException;
use model\entity\User;

class thirdLogin extends AppApi
{
    protected $auth_data;

    protected function init()
    {
        $this->addParam('auth_data');
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        $auth_data_array = json_decode($this->auth_data, true);
        if (empty($auth_data_array)) {
            throw new ApiException('第三方登录信息缺失,无法注册', "INFORMATION_LOSE_REGISTER_FAIL");
        }
        switch ($auth_data_array['user_from']) {
            case 'qq':
                $uid = User::regByQQ($auth_data_array);
                break;
            case 'weixin':
                $uid = User::regByWeiXin($auth_data_array);
                break;
            case 'weibo':
                $uid = User::regByWeiBo($auth_data_array);
                break;
            default:
                throw new ApiException('暂时不支持这种方式登录', "CANNOT_REDISTER");
        }

        setcookie("uid", $uid, time() + 3600 * 2, '/');
        /** @var User $currentUserObj */
        $currentUserObj = User::getInstance($uid);
        setcookie("auth", $currentUserObj->getAuth(), time() + 3600 * 24 * 60, '/');
    }

}
