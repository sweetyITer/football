<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/17
 * Time: 14:10
 */
namespace app\api\order;

use app\AppApi;
use mmapi\api\ApiException;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use model\entity\Order;

class confirmReceipt extends AppApi
{
    protected $orderId;

    protected function init()
    {
        $this->addParam('orderId')->setType(ApiParams::TYPE_INT);
        $this->denyResubmit();
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
        if (in_array($orderObj->getShippingStatus(), ['wait', 'prepare'])) {
            throw new ApiException('订单在配货或者未发货', 'ORDER_WAITED_OR_NO_SHIPPED');
        }
        $orderObj
            ->setShippingStatus('received')
            ->save();
    }
}