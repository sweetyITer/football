<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/5
 * Time: 15:09
 */
namespace app\api\video;

use app\AppApi;
use mmapi\core\Api;
use mmapi\core\AppException;
use mmapi\core\Config;
use mmapi\core\Db;
use mmapi\core\ApiParams;
use Doctrine\ORM\Tools\Pagination\Paginator;
use model\entity\Video;

class vList extends AppApi
{
    protected $groupId;

    protected function init()
    {
        $this->addParam('groupId')->setRequire(false);
        $this->get('auth')->setRequire(false);
        $this->addParam('p')->setRequire(false)->setDefault(1);
        $this->addParam('size')->setRequire(false)->setDefault(10);
    }

    public function run()
    {
        if (!empty($this->groupId) && !in_array($this->groupId, ['teach', 'gogoal', 'game', 'contest'])) {
            throw new AppException('无效视频类型', 'VIDEO_TYPE_INVALID');
        }
        $query     = $this->db->dqlBuilder()
            ->select('v')
            ->from(Video::class, 'v')
            ->where('v.groupId = :gi')
            ->getQuery()
            ->setParameter('gi', $this->groupId == null ? 'teach' : $this->groupId)
            ->setFirstResult(($this->p - 1) * $this->size)
            ->setMaxResults($this->size);
        $paginator = new Paginator($query, true);

        $list = [];
        /** @var Video $item */
        foreach ($paginator as $item) {
            $list[] = [
                'videoId' => $item->getId(),
                'title'   => $item->getTitle(),
                'cover'   => $item->getCover(),
            ];
        }
        $this->set('data', [
            'count' => $paginator->count(),
            'list'  => $list,
        ]);
    }
}