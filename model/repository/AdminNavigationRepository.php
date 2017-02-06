<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/15
 * Time: 14:07
 */

namespace model\repository;

use Doctrine\ORM\EntityRepository;
use mmapi\core\Db;
use model\entity\AdminNavigation;

class AdminNavigationRepository extends EntityRepository
{
    /**
     * @desc   getList 获取列表
     * @author chenmingming
     * @return array
     */
    public function getList()
    {
        $dql = "SELECT n FROM " . AdminNavigation::class . " n WHERE n.status='open' ORDER BY n.pid ASC,n.orderNum ASC";

        $data = $this->getEntityManager()
            ->createQuery($dql)
            ->getResult();
        $list = [];
        /** @var AdminNavigation $item */
        foreach ($data as $item) {
            if ($item->getPid() == 0) {
                $list[$item->getId()] = $item;
            } else {
                if (isset($list[$item->getPid()])) {
                    $this->find($item->getPid())
                        ->assignedTo($item);
                }
            }
        }

        return array_values($list);
    }

    /**
     * @desc   getArrayList
     * @author chenmingming
     * @return array
     */
    public function getArrayList()
    {
        $dql = "SELECT n FROM " . AdminNavigation::class . " n ORDER BY n.pid ASC,n.orderNum ASC";

        $data = $this->getEntityManager()
            ->createQuery($dql)
            ->getArrayResult();
        $list = [];
        foreach ($data as $v) {
            if ($v['pid'] == 0) {
                $list[$v['id']] = $v;
            } else {
                if (isset($list[$v['pid']])) {
                    $list[$v['pid']]['children'][] = $v;
                }
            }
        }

        return array_values($list);
    }

    /**
     * @desc   getParentNav
     * @author chenmingming
     * @return array
     */
    public function getParentNav()
    {
        $dql = "SELECT n FROM " . AdminNavigation::class . " n WHERE n.pid = ?1 ORDER BY n.orderNum ASC";

        return $this->getEntityManager()->createQuery($dql)
            ->setParameter(1, 0)
            ->getArrayResult();

    }
}