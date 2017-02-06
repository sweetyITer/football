<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/8/8
 * Time: 01:08
 */

namespace app\admin\permission;

use app\AdminApi;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use mmapi\core\Db;
use model\entity\AdminPermission;

class Del extends AdminApi
{

    /**
     * init
     * @author yuqi
     */
    protected function init()
    {
        $this->addParam('id')->setType(ApiParams::TYPE_INT);
    }

    /**
     * run
     * @author yuqi
     * @throws AppException
     */
    public function run()
    {
        /** @var AdminPermission $adminPermission */
        $adminPermission = AdminPermission::getInstance($this->id);
        if (is_null($adminPermission)) {
            throw new AppException("该权限不存在", "161636");
        }
        $adminPermission->remove();
    }
}