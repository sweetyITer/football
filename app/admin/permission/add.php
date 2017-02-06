<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/8/8
 * Time: 00:24
 */

namespace app\admin\permission;

use app\AdminApi;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use mmapi\core\Db;
use model\entity\AdminPermission;

class addAjax extends AdminApi
{
    protected function init()
    {
        $this->addParam('id')->setType(ApiParams::TYPE_INT);
        $this->addParams(['model', 'action', 'text']);
        $this->addParam('status')->setRequire(false)->setDefault(1);
        $this->addParam('group')->setRequire(false)->setDefault('admin');
    }

    public function run()
    {
        if ($this->id) {
            /** @var AdminPermission $adminPermission */
            $adminPermission = AdminPermission::getInstance($this->id);
            if (is_null($adminPermission)) {
                throw new AppException("该权限不存在", 'NAVIGATION_NOT_FUND');
            }
        } else {
            $adminPermission = new AdminPermission();
        }
        $adminPermission
            ->setGroup($this->group)
            ->setStatus($this->status)
            ->setModel($this->model)
            ->setAction($this->action)
            ->setText($this->text)
            ->save();
    }

}