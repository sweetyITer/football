<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/16
 * Time: 17:39
 */
namespace app\api\order;

use app\AppApi;
use mmapi\api\ApiException;
use mmapi\core\ApiParams;
use model\entity\Order;

class delete extends AppApi
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
        if (is_null($orderObj) || $orderObj->getUser() != $this->user) {
            throw new ApiException('不合法的订单', 'ORDER_ID_NOT_LEGAL');
        }
        $orderObj->remove();
    }
}