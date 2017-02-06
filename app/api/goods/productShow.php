<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/17
 * Time: 14:30
 */
namespace app\api\goods;

use app\AppApi;
use model\entity\Product;
use model\entity\Attribute;
use model\entity\Goods;

class productShow extends AppApi
{
    protected $goods_id;

    protected function init()
    {
        $this->addParam('goods_id');
        $this->get('auth')->setRequire(false);
    }

    /**
     * run @desc 款式展示
     *
     * @author wangjuan
     */
    public function run()
    {
        /** @var Goods $goodsObj */
        $goodsObj = Goods::getInstance($this->goods_id);
        $attrList = $goodsObj->getAttrIndexList();

        //获取商品信息
        $goodsInfo = [
            "goods_id" => $goodsObj->getId(),
            'title'    => $goodsObj->getTitle(),
            'pic'      => $goodsObj->getCoverImg() ? $goodsObj->getCoverImg()->getUrl() : '',
            'price'    => $goodsObj->getCurrentPrice(),
            'stock'    => $goodsObj->getStock(),
        ];

        //商品属性
        $list = [];
        foreach ($attrList as $k => $v) {
            /** @var Attribute $attrName */
            $attrObj  = Attribute::getInstance($k);
            $attrName = $attrObj->getAttrName();
            $list[]   = [
                'attrName'   => $attrName,
                'attrDetail' => $v,
            ];
        }

        //款式
        $productObjs  = $goodsObj->getProductObjs();
        $productStyle = [];
        /** @var Product $pro */
        foreach ($productObjs as $pro) {
            $productStyle[] = [
                "product_id" => $pro->getId(),
                "key"        => $pro->getKey(),
                "img"        => $pro->getCoverImg() ? $pro->getCoverImg()->getUrl() : '',
                "stock"      => $pro->getStock(),
                "price"      => (float)$goodsObj->getCurrentPrice() + (float)$pro->getPrice(),
            ];
        }
        $data = [
            "goodsInfo" => $goodsInfo,
        ];
        //判断是multi
        if (!is_null($goodsObj->getAttributeSet())) {
            $data["attrList"]     = $list;
            $data["productStyle"] = $productStyle;
        }
        $this->set('data', $data);
    }
}