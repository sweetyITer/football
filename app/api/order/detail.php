<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/17
 * Time: 15:30
 */
namespace app\api\order;

use app\AppApi;
use mmapi\api\ApiException;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use model\entity\Order;
use model\entity\OrderAddress;

class detail extends AppApi
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
        /** @var OrderAddress $orderAddressObj */
        $orderAddressObj = OrderAddress::getRepository()->findOneBy(['order' => $orderObj]);
        if (is_null($orderAddressObj)) {
            throw new ApiException('无此订单地址信息', 'NO_THIS_ORDER_MSG');
        }
        $info = [
            'order_sn'       => $orderObj->getOrderSn(),
            'shippingStatus' => $orderObj->getShippingStatus(),
            'name'           => $orderAddressObj->getConsignee(),
            'address'        => $orderAddressObj->getAddressName(),
            'phone'          => $orderAddressObj->getMobile(),
            'goodsAmount'    => $orderObj->getGoodsAmount(),
            'createTime'     => $orderObj->getCreateTime(),
        ];
        $this->set('data', $info);
    }
}