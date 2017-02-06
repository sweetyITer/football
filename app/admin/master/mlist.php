<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/10/25
 * Time: 15:17
 */

namespace app\admin\master;

use app\AdminApi;
use Doctrine\ORM\Tools\Pagination\Paginator;
use model\entity\AdminMaster;

class mList extends AdminApi
{
    protected $page;
    protected $size = 20;

    protected function init()
    {
        $this->addParam('page')->setRequire(false)->setDefault(1)->setType(self::TYPE_INT);
    }

    /**
     * run
     *
     * @author yuqi
     */
    public function run()
    {
        $this->page = max(1, $this->page);
        $query      = $this->db->dqlBuilder()
            ->select('g')
            ->from(AdminMaster::class, 'g')
            ->addOrderBy('g.id', 'DESC')
            ->getQuery()
            ->setFirstResult(($this->page - 1) * $this->size)
            ->setMaxResults($this->size);
        $paginator = new Paginator($query, true);

        $list = [];
        /** @var AdminMaster $item */
        foreach ($paginator as $item) {
            $list[] = [
                'id'            => $item->getId(),
                'groupId'       => $item->getGroup()->getId(),
                'groupName'     => $item->getGroup()->getName(),
                'email'         => $item->getEmail(),
                'phone'         => $item->getPhone(),
                'userFace'      => $item->getUserFace(),
                'userName'      => $item->getUserName(),
                'nickName'      => $item->getNickName(),
                'lastLoginTime' => $item->getLastLoginTime(),
                'isLock'        => $item->isLock(),
            ];
        }
        $this->set('data', [
            'count' => $paginator->count(),
            'list'  => $list,
        ]);
    }
}