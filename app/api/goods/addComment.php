<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/18
 * Time: 10:45
 */
namespace app\api\Goods;

use app\AppApi;
use mmapi\api\ApiException;
use model\entity\Goods;
use model\entity\Order;
use model\entity\OrderGoods;
use model\entity\MallGoodsComment;

class addComment extends AppApi
{
    protected $order_id;
    protected $content;

    protected function init()
    {
        $this->addParams(['content', 'order_id']);
    }

    public function run()
    {
        //判断当前用户的订单里面是否含有当前商品
        /** @var Order $orderObj */
        $orderObj = Order::tryInstance($this->order_id, ['订单无效', 'ORDER_UNVALID']);
        if ($orderObj->isDelete()) {
            throw new ApiException('订单不存在', 'GOODS_DELETED');
        }
        if ($orderObj->getShippingStatus() != "received") {
            throw new ApiException('用户未签收,不能评价', 'USER_NOT_RECEIVED');
        }
        if ($orderObj->getUser() != $this->user) {
            throw new ApiException('该用户没有购买本商品', 'USER_NOT_BUY');
        }
        /** @var OrderGoods $orderGoodsObj */
        $orderGoodsObj = OrderGoods::getInstance($orderObj->getId());

        //根据订单id获取goodsId
        $goodsObj = $orderGoodsObj->getGoods();

        /** @var MallGoodsComment $mallGoodsCommentObj */
        $mallGoodsCommentObj = new MallGoodsComment();
        $mallGoodsCommentObj
            ->setUserId($this->user->getId())
            ->setContent($this->content)
            ->setGoodsId($goodsObj->getId())
            ->save();

        //商品的评论数增加1
        $goodsObj->setCommentCount((int)$goodsObj->getCommentCount() + 1)
            ->save();
    }

}