<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/10/25
 * Time: 15:17
 */

namespace app\admin\master;

use app\AdminApi;
use mmapi\core\Db;

class groupList extends AdminApi
{
    protected $page;
    protected $size = 20;
    protected $search;

    protected function init()
    {
        $this->addParam('page')->setRequire(false)->setDefault(1)->setType(self::TYPE_INT);
        $this->addParam('search')->setRequire(false)->setType(self::TYPE_STRING);
    }

    /**
     * run
     *
     * @author yuqi
     */
    public function run()
    {
        $this->page = max(1, $this->page);
        $group_sql  = Db::create()->sqlBuilder()
            ->select()
            ->from('admin_master_group');

        if ($this->search != 'all') {
            $group_sql->limit(($this->page - 1) * $this->size, $this->size);
        }
        $data = $group_sql
            ->order('id desc')
            ->fetchAll();
        $count = Db::create()->sqlBuilder()
            ->select('count(*) as count')
            ->from('admin_master_group')
            ->fetch();
        $this->set('count', $count['count']);
        $this->set('data', $data);
    }
}