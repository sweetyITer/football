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

class gList extends AdminApi
{

    protected function init()
    {
        // TODO: Implement init() method.
    }

    /**
     * run
     * @author yuqi
     */
    public function run()
    {
        $parentPermission = Db::create()->sqlBuilder()
            ->select()
            ->from('admin_permission')
            ->where('action')->eq('*')
            ->order('id asc')
            ->fetchAll();
        $this->set('data', $parentPermission);
    }
}