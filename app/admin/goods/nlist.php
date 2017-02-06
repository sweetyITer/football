<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/17
 * Time: 22:13
 */

namespace app\admin\goods;

use app\AdminApi;
use Doctrine\ORM\Tools\Pagination\Paginator;
use mmapi\core\ApiParams;
use mmapi\core\Db;
use model\entity\Brand;
use model\entity\Category;
use model\entity\Goods;
use model\entity\GoodsGallery;

class nlist extends AdminApi
{
    protected function init()
    {
        $this->addParam('p')->setType(ApiParams::TYPE_INT)->setRequire(false)->setDefault(1);
        $this->addParam('size')->setType(ApiParams::TYPE_INT)->setRequire(false)->setDefault(10);
    }

    public function run()
    {
        $query = $this->db->dqlBuilder()
            ->select('g')
            ->from(Goods::class, 'g')
            ->addOrderBy('g.id', 'DESC')
            ->getQuery()
            ->setFirstResult(($this->p - 1) * $this->size)
            ->setMaxResults($this->size);

        $paginator = new Paginator($query, true);

        $list = [];
        /** @var Goods $item */
        foreach ($paginator as $item) {
            $list[] = [
                'id'           => $item->getId(),
                'brandName'    => $item->getBrand()->getName(),
                'categoryName' => $item->getCid()->getName(),
                'title'        => $item->getTitle(),
                'updateTime'   => $item->getUpdateTime()->format('Y-m-d H:i:s'),
                'orginalPrice' => $item->getOriginalPrice(),
                'currentPrice' => $item->getCurrentPrice(),
                'brief'        => $item->getBrief(),
                'stock'        => $item->getStock(),
                'isOnSale'     => $item->isOnSale(),
                'isDelete'     => $item->isDelete(),
                'coverImg'     => $item->getCoverImg() ? $item->getCoverImg()->getThumb(GoodsGallery::STYLE_200x200) : '',
            ];
        }
        $this->set('data', [
            'count' => $paginator->count(),
            'list'  => $list,
        ]);
    }

}