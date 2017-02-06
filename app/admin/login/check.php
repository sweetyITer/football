<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/10/24
 * Time: 23:33
 */

namespace app\admin\login;

use app\AdminApi;
use mmapi\core\Api;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use mmapi\core\Db;
use model\entity\AdminMaster;

class check extends AdminApi
{
    protected $username;
    protected $password;

    protected function init()
    {
        $this->addParam('username')->setMethod(ApiParams::METHOD_POST);
        $this->addParam('password')->setMethod(ApiParams::METHOD_POST);
        $this->withoutRequireLogged();
    }

    public function run()
    {
        /** @var AdminMaster $adminMaster */
        $adminMaster = AdminMaster::getRepository()
            ->findOneBy(['userName' => $this->username]);
        if (is_null($adminMaster)) {
            throw new AppException("账号或者密码错误", 'ACCOUNT_ERROR');
        }
        if ($adminMaster->isLock()) {
            throw new AppException('用户已经锁定,请联系管理员', 'USER_LOCKED');
        }

        if (!$adminMaster->verifyPassword($this->password)) {
            throw new AppException("用户账号或者密码错误", 'ACCOUNT_ERROR');
        }
        $adminMaster->regLogin();
    }
}