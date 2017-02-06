<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/18
 * Time: 15:00
 */
namespace app\api\order;

use app\AppApi;
use mmapi\api\ApiException;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use model\entity\Order;
use model\entity\OrderGoods;

class pay extends AppApi
{
    protected $orderId;

    protected function init()
    {
        $this->addParam('orderId')->setType(ApiParams::TYPE_INT);
    }

    public function run()
    {
        /** @var Order $orderObj */
        $orderObj = Order::getInstance($this->orderId);
        if ($orderObj->getUser() != $this->user) {
            throw new AppException('非法用户', 'USER_NOT_LEGAL');
        }
        if ($orderObj->getOrderStatus() != 'confirmed') {
            throw new ApiException('订单状态不正确', 'ORDER_STATUS_NOT_RIGHT');
        }
        /** @var OrderGoods $orderGoodsObj */
        $orderGoodsObj = OrderGoods::getRepository()->findOneBy(['order' => $orderObj]);
        if (is_null($orderGoodsObj)) {
            throw new ApiException('无订单商品', 'NO_ORDER_GOODS');
        }
        if ($orderGoodsObj->getProduct()->getStock() <= 0) {
            throw new ApiException('该商品库存不足', 'STOCK_NOT_ENOUGH');
        }
        if ($orderObj->getPayWay() == 'alipay') {
        }
        if ($orderObj->getPayWay() == 'wexin') {
        }
    }
}