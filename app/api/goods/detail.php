<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/17
 * Time: 12:16
 */
namespace app\api\goods;

use app\AppApi;
use mmapi\api\ApiException;
use model\entity\MallGoodsComment;
use model\entity\GoodsDetail;
use model\entity\Attribute;
use model\entity\Goods;

class detail extends AppApi
{
    protected $goods_id;
    protected $page;
    protected $size;

    protected function init()
    {
        $this->addParams(['goods_id', 'page', 'size']);
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        $this->page || $this->page = 1;
        $this->size || $this->size = 5;

        /** @var Goods $goodsObj */
        $goodsObj = Goods::tryInstance($this->goods_id, ['商品无效', 'GOODS_UNVALID']);
        if($goodsObj->isDelete()){
            throw new ApiException('商品不存在','GOODS_DELETED');
        }
        $attrList = $goodsObj->getAttrIndexList();
        $list     = [];

        foreach ($attrList as $k => $v) {
            /** @var Attribute $attrObj */
            $attrObj  = Attribute::getInstance($k);
            $attrName = $attrObj->getAttrName();
            $list[]   = [
                'attrName'   => $attrName,
                'attrDetail' => $v,
            ];
        }

        /** @var GoodsDetail $goodsDetailObj */
        $goodsDetailObj = GoodsDetail::tryInstance(GoodsDetail::getIdByGoodsId($goodsObj->getId()), ['商品详情不存在', 'GOODSDETAIL_UNVALID']);
        $goodsInfo      = [
            "title"          => $goodsObj->getTitle(),
            "current_price"  => $goodsObj->getCurrentPrice(),
            "original_price" => $goodsObj->getOriginalPrice(),
            "cover"          => $goodsDetailObj->getCoverImgs(),
            "imgs"           => $goodsDetailObj->getContentImgs(),
            "transport_fee"  => $goodsObj->getTransportFee() > 0 ? $goodsObj->getTransportFee() . "元邮费" : "包邮",
            "comment_count"  => $goodsObj->getCommentCount(),
            "face_img"       => MallGoodsComment::getFaceImgs($goodsObj, $this->page, $this->size),
            "commentList"    => MallGoodsComment::getList($goodsObj, $this->page, $this->size, $this->user ? $this->user : null),
        ];

        if (!is_null($goodsObj->getAttributeSet())) {
            $goodsInfo['attrList'] = $list;
        }

        $this->set('data', $goodsInfo);
    }
}