<?php
/**
 * Created by PhpStorm.
 * User: baofan
 * Date: 2016/11/7
 * Time: 16:04
 */

namespace app\admin\master;

use app\AdminApi;
use mmapi\core\ApiParams;
use model\entity\AdminMaster;
use model\entity\AdminMasterGroup;

class delGroup extends AdminApi
{

    protected function init()
    {
        $this->addParam('id')->setType(ApiParams::TYPE_INT)->setRequire('分组id不能为空');
    }

    /**
     * run
     *
     * @author yuqi
     */
    public function run()
    {
        /** @var AdminMasterGroup $groupAbj */
        $groupAbj = AdminMasterGroup::getInstance($this->id);
        $groupAbj->remove();
    }
}