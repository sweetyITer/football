<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/19
 * Time: 12:34
 */

namespace app\admin\brand;

use app\AdminApi;
use mmapi\core\Db;
use model\entity\Brand;

class blist extends AdminApi
{
    protected $q;

    protected function init()
    {
        $this->addParam('q');
    }

    public function run()
    {
        // TODO: Implement run() method.
        $query =$this->db->dqlBuilder()->select('c.id,c.name as text')->from(Brand::class, 'c')->where('c.name like :kw')->getQuery();
        $query->setParameter('kw', "%{$this->q}%")
            ->setMaxResults(20);

        $this->set('data', $query->getArrayResult());
    }

}