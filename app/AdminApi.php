<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/14
 * Time: 21:09
 */

namespace app;

use library\extend\Aes;
use mmapi\api\LoginApi;
use mmapi\core\AppException;
use mmapi\core\Config;
use mmapi\core\Db;
use mmapi\core\Log;
use model\entity\AdminMaster;

abstract class AdminApi extends LoginApi
{

    /** @var  AdminMaster */
    protected $adminMaster;
    protected $db;

    public function __construct()
    {
        $this->db = Db::create();
        parent::__construct();
    }

    /**
     * @desc   checkLogin
     * @author chenmingming
     * @throws AppException
     */
    public function checkLogin()
    {
        if ($_COOKIE[Config::get('auth.name')]) {
            list($uid, $guid, $time) = explode(
                "\t", Aes::decrypt($_COOKIE[Config::get('auth.name')], Config::get('auth.key'))
            );
            //该auth时间有效时间 必须在当前时间之后 且不能多于12个小时
            if ($time < time()) {
                throw  new AppException('登录状态已经过期，请重新登录', 'NOT_LOGIN_EXPIRE');
            }

            if (!isset($_COOKIE['uid']) || $_COOKIE['uid'] != $uid) {
                setcookie('uid', $uid, time() + 86400 * 3, '/');
                $_COOKIE['uid'] = $uid;
            }
            /** @var  adminMaster */
            $this->adminMaster = AdminMaster::getInstance($uid);
            if (is_null($this->adminMaster)) {
                throw new AppException("该账号不存在", "account_not_exist");
            }
            if ($this->adminMaster->isLock()) {
                throw  new AppException('您的账号已经锁定，请联系管理员', 'NOT_LOGIN_USERLOCKED');
            }

            if ($guid != $this->adminMaster->getGuid()) {
                throw  new AppException('您已经在其他地方登陆，您已经退出当前登陆', 'NOT_LOGIN_OTHERLOGINED');
            }

            define('SUPPER_MASTER', $this->adminMaster->getGroup()->getId() == 1);
            define('LOGIN_UID', $this->adminMaster->getId());
            define('LOGIN_NICKNAME', $this->adminMaster->getNickName());
        } else {
            throw  new AppException('请登录', 'REQUIRE_LOGGED');
        }
    }

}