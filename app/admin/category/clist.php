<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/19
 * Time: 10:34
 */

namespace app\admin\category;

use app\AdminApi;
use mmapi\core\Db;
use model\entity\Category;

class clist extends AdminApi
{
    protected function init()
    {
        // TODO: Implement init() method.
        $this->addParam('q');
    }

    public function run()
    {
        // TODO: Implement run() method.
        $query = $this->db->dqlBuilder()
            ->select('c.id,c.name as text')
            ->from(Category::class, 'c')
            ->where('c.name like :kw')
            ->getQuery();
        $query
            ->setParameter('kw', "%{$this->q}%")
            ->setMaxResults(20);

        $this->set('data', $query->getArrayResult());
    }

}