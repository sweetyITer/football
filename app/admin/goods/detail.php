<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/18
 * Time: 21:50
 */

namespace app\admin\goods;

use app\AdminApi;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use mmapi\core\Db;
use model\entity\Goods;
use model\entity\GoodsAttr;

class detail extends AdminApi
{
    protected function init()
    {
        $this->addParam('id')->setType(ApiParams::TYPE_INT);
    }

    public function run()
    {
        /** @var Goods $goodsObj */
        $goodsObj = Goods::getInstance($this->id);
        if (is_null($goodsObj)) {
            throw new AppException('该商品不存在', 'GOODS_NOT_EXIST');
        }
        $goods = [
            'id'              => $goodsObj->getId(),
            'title'           => $goodsObj->getTitle(),
            'subTitle'        => $goodsObj->getSubTitle(),
            'goodsSn'         => $goodsObj->getGoodsSn(),
            'brand'           => $goodsObj->getBrand()->getId(),
            'brandName'       => $goodsObj->getBrand()->getName(),
            'category'        => $goodsObj->getCid()->getId(),
            'categoryName'    => $goodsObj->getCid()->getName(),
            'orginalPrice'    => $goodsObj->getOriginalPrice(),
            'currentPrice'    => $goodsObj->getCurrentPrice(),
            'brief'           => $goodsObj->getBrief(),
            'stock'           => $goodsObj->getStock(),
            'keywords'        => $goodsObj->getKeywords(),
            'isBest'          => $goodsObj->isBest() ? 'true' : 'false',
            'note'            => $goodsObj->getNote(),
            'cover'           => $goodsObj->getCoverImg() ? $goodsObj->getCoverImg()->getUrl() : '',
            'isMultipleStyle' => !is_null($goodsObj->getAttributeSet()),
            'attributeSetId'  => 0,
        ];

        if ($goods['isMultipleStyle']) {
            $goods['attributeSetId'] = $goodsObj->getAttributeSet()->getId();
            $attrList                = $goodsObj->getAttrIndexList();
            $productsList            = $goodsObj->getProductsArray();
        }

        $this->set('data', compact('goods', 'attrList', 'productsList'));
    }

}