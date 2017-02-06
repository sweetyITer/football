<?php
/**
 * Created by PhpStorm.
 * User: baofan
 * Date: 2016/11/7
 * Time: 16:27
 */
namespace app\admin\master;

use app\AdminApi;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use model\entity\AdminMaster;
use model\entity\AdminMasterGroup;

class addGroup extends AdminApi
{
    protected $id;
    protected $name;

    protected function init()
    {
        $this->addParam('id')->setRequire(false)->setType(ApiParams::TYPE_INT);
        $this->addParam('name')->setRequire('请输入内容~')->setType(ApiParams::TYPE_STRING);
    }

    /**
     * run
     * @author yuqi
     * @throws AppException
     */
    public function run()
    {
        //判断该分组是否存在
        if ($this->id) {
            /** @var AdminMasterGroup $groupObj */
            $groupObj = AdminMasterGroup::getInstance($this->id);
            if (is_null($groupObj)) {
                throw new AppException("该分组不存在", '171447');
            }
        } else {
            $groupObj = new AdminMasterGroup();
        }

        $groupObj
            ->setName($this->name)
            ->save();
    }
}