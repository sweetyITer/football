<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/8/8
 * Time: 00:21
 */

namespace app\admin\permission;

use app\AdminApi;
use mmapi\core\Db;

/**
 * Class listAjax
 *
 * @package Sdxapp\Admin\Ajax\Permission
 */
class pList extends AdminApi
{

    protected function init()
    {
        // TODO: Implement init() method.
        $this->addParam('model')
            ->setRequire('未选择分组')
            ->setDefault('permission');
    }

    /**
     * @desc   run
     * @author chenmingming
     */
    public function run()
    {
        $list = Db::create()->sqlBuilder()
            ->select()
            ->from('admin_permission')
            ->where('model')->eq($this->model)
            ->fetchAll();
        $this->set('data', $list);
    }
}