<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/19
 * Time: 15:12
 */

namespace app\admin\attrset;

use app\AdminApi;
use Doctrine\ORM\Tools\Pagination\Paginator;
use mmapi\core\Db;
use model\entity\AttributeSet;

class alist extends AdminApi
{
    protected function init()
    {
        $this->addParam('p')->setRequire(false)->setDefault(1);
        $this->addParam('size')->setRequire(false)->setDefault(10);
    }

    public function run()
    {
        $query = $this->db->dqlBuilder()
            ->select('a')
            ->from(AttributeSet::class, 'a')
            ->getQuery()
            ->setFirstResult(($this->p - 1) * $this->size)
            ->setMaxResults($this->size);

        $paginator = new Paginator($query, true);

        $list = [];
        /** @var AttributeSet $item */
        foreach ($paginator as $item) {
            $list[] = [
                'id'           => $item->getId(),
                'name'         => $item->getName(),
                'categoryName' => $item->getCid() ? $item->getCid()->getName() : '通用',
                'addTime'      => $item->getAddTime(),
            ];
        }
        $this->set('data', [
            'count' => $paginator->count(),
            'list'  => $list,
        ]);
    }

}