<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/20
 * Time: 14:13
 */
namespace app\api\order;

use app\AppApi;
use mmapi\api\ApiException;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use model\entity\Order;

class remindShip extends AppApi
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
            throw new AppException('用户不合法', 'USER_NOT_LEGAL');
        }
        if ($orderObj->getOrderStatus() != 'confirmed') {
            throw new ApiException('订单状态不正确', 'ORDER_STATUS_NOT_RIGHT');
        }
        if (in_array($orderObj->getShippingStatus(), ['shipping', 'received'])) {
            throw new ApiException('订单已经发货或者已经收货', 'ORDER_SHIPPED_OR_RECEIVED');
        }
    }
}
