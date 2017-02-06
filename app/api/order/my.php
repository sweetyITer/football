<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/16
 * Time: 18:28
 */
namespace app\api\order;

use app\AppApi;
use model\entity\Order;

class my extends AppApi
{
    protected $payStatus;
    protected $shippingStatus;

    protected function init()
    {
        $this->addParam('payStatus')->setRequire(false);
        $this->addParam('shippingStatus')->setRequire(false);
    }

    public function run()
    {
        if (empty($this->payStatus) && empty($this->shippingStatus)) {
            $order = Order::getRepository()->findBy([
                'user'     => $this->user,
                'isDelete' => 0,
            ]);
        } else if ($this->payStatus == 'not_pay' && empty($this->shippingStatus)) {
            $order = Order::getRepository()->findBy([
                'user'      => $this->user,
                'payStatus' => $this->payStatus,
                'isDelete'  => 0,
            ]);
        } else if (empty($this->payStatus) && in_array($this->shippingStatus, ['shipping', 'received'])) {
            $order = Order::getRepository()->findBy([
                'user'           => $this->user,
                'shippingStatus' => $this->shippingStatus,
                'isDelete'       => 0,
            ]);
        } else {
            $order = Order::getRepository()->findBy([
                'user'           => $this->user,
                'payStatus'      => $this->payStatus,
                'shippingStatus' => $this->shippingStatus,
                'isDelete'       => 0,
            ]);
        }
        $data = [];
        /** @var Order $item */
        foreach ($order as $item) {
            $data[] = [
                'payWay' => $item->getPayWay(),
            ];
        }
        $this->set('list', $data);
    }
}