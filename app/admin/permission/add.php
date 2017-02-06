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
use mmapi\core\Cache;
use mmapi\core\Db;
use model\entity\AdminPermission;

class add extends AdminApi
{
    protected function init()
    {
        $this->addParam('id')->setType(ApiParams::TYPE_INT)->setRequire(false)->setDefault(0);
        $this->addParam('status')->setRequire(false)->setDefault(1);
        $this->addParams(['model', 'action', 'text']);
    }

    /**
     * run
     * @author yuqi
     * @throws AppException
     */
    public function run()
    {
        if ($this->id) {
            /** @var AdminPermission $adminPermission */
            $adminPermission = AdminPermission::getInstance($this->id);
            if (is_null($adminPermission)) {
                throw new AppException("该权限不存在", '161622');
            }
        } else {
            $adminPermission = new AdminPermission();
        }
        $adminPermission
            ->setStatus($this->status)
            ->setModel($this->model)
            ->setAction($this->action)
            ->setText($this->text)
            ->save();
    }

}