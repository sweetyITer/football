<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/17
 * Time: 13:29
 */
namespace app\api\order;

use app\AppApi;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use model\entity\Order;
use model\entity\OrderRefund;

class refund extends AppApi
{
    protected $orderId;
    protected $remark;

    protected function init()
    {
        $this->addParam('orderId')->setType(ApiParams::TYPE_INT);
        $this->addParam('remark')->setRequire(false);
        $this->denyResubmit();
    }

    public function run()
    {
        /** @var Order $orderObj */
        $orderObj = Order::getInstance($this->orderId);
        if ($orderObj->getUser() != $this->user) {
            throw new AppException('非法用户', 'USER_NOT_LEGAL');
        }
        $refundObj = new OrderRefund();
        $refundObj
            ->setOrder($orderObj)
            ->save();
    }
}