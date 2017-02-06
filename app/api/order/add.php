<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/16
 * Time: 14:52
 */
namespace app\api\order;

use app\AppApi;
use mmapi\api\ApiException;
use mmapi\core\Db;
use mmapi\core\Log;
use model\entity\Order;
use model\entity\Goods;
use model\entity\OrderGoods;
use model\entity\OrderAddress;
use model\entity\Product;
use model\entity\UserAddress;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\Test\LoggerInterfaceTest;

class add extends AppApi
{
    protected $addressId;
    protected $productId; //可以传递
    protected $goodsId; //必须传递
    protected $num;
    protected $remark;
    protected $payWay;

    protected function init()
    {
        $this->addParams(['addressId', 'productId', 'num', 'payWay', 'goodsId', 'remark']);
        $this->addParam('remark')->setRequire(false);
    }

    public function run()
    {
        /** @var Goods $goodsObj */
        $goodsObj = Goods::tryInstance($this->goodsId, ['商品无效', 'GOODS_UNVALID']);
        if ($goodsObj->isDelete() || $goodsObj->isOnSale() == false) {
            throw new ApiException('商品已经被删除或者没有上架', 'GOODS_DELETED');
        }
        $goodsAmount = null;
        $productObj  = null;

        //单一款式
        if (is_null($goodsObj->getAttributeSet())) {
            if ($goodsObj->getStock() < $this->num) {
                throw new ApiException('库存不足', 'STOCK_NOT_ENOUGH');
            }
            //总价格
            $goodsAmount = $goodsObj->getCurrentPrice() * $this->num;
        } else {
            if ($this->productId > 0) {

                /** @var Product $productObj */
                $productObj = Product::tryInstance($this->productId, ['款式不存在', 'PRODUCT_UNVALID']);
                if ($productObj->isDelete()) {
                    throw new ApiException('款式已经被删除', 'PRODUCT_DELETED');
                }
                if ($productObj->getStock() < $this->num) {
                    throw new ApiException('库存不足', 'STOCK_NOT_ENOUGH');
                }
            }
            $goodsAmount = $goodsObj->getCurrentPrice() * $this->num;
        }
        /** @var UserAddress $userAddressObj */
        $userAddressObj = UserAddress::tryInstance($this->addressId, ['地址id无效', 'ADDRESS_UNVALID']);
        if ($userAddressObj->getUser() != $this->user) {
            throw new ApiException('地址不合法', 'ADDRESS_ID_NOT_LEGAL');
        }
        //mall_order表
        $orderObj = new Order();
        $orderObj
            ->setUser($this->user)
            ->setOrderSn($this->payWay, null)
            ->setGoodsAmount($goodsAmount)
            ->setPayWay($this->payWay)
            ->setUserRemark($this->remark)
            ->setIsDelete(0)
            ->save();
       /* $orderAddress = new OrderAddress();
        $orderAddress
            ->setOrder($orderObj)
            ->setAddress(UserAddress::getInstance($this->addressId))
            ->save();*/
        $orderAddress = new OrderAddress();
        $orderAddress
            ->setOrder($orderObj)
            ->setAddress(UserAddress::getInstance($this->addressId))
            ->save();
        //mall_order_address表
        if (!is_null($orderObj) && !is_null($userAddressObj)) {
            Db::create()->sqlBuilder()
                ->insert('mall_order_address')
                ->set('order_id')->value($orderObj->getId())
                ->set('address_name')->value($userAddressObj->getAddressName())
                ->set('consignee')->value($userAddressObj->getConsignee())
                ->set('sex')->value($userAddressObj->getSex())
                ->set('email')->value($userAddressObj->getEmail())
                ->set('country')->value($userAddressObj->getCountry()->getRegionId())
                ->set('province')->value($userAddressObj->getProvince()->getRegionId())
                ->set('city')->value($userAddressObj->getCity()->getRegionId())
                ->set('district')->value($userAddressObj->getDistrict()->getRegionId())
                ->set('address')->value($userAddressObj->getAddress())
                ->set('zipcode')->value($userAddressObj->getZipcode())
                ->set('mobile')->value($userAddressObj->getMobile())
                ->set('sign_building')->value($userAddressObj->getSignBuilding())
                ->set('add_time')->value(date('Y-m-d H:i:s', time()))
                ->exec();
            /** @var UserAddress $userAddressObj */
            /*  $orderAddressObj = new OrderAddress();
              $orderAddressObj->setOrder($orderObj)
                  ->setAddress($userAddressObj)
                  ->setAddTime(date('Y-m-d H:i:s', time()))
                  ->save();*/
        }

        //mall_order_goods表
        if (is_null($productObj)) {
            $orderGoodsObj = new OrderGoods();
            $orderGoodsObj
                ->setAttrBrief($productObj->getGoodsAttr())
                ->setGoodsTitle($goodsObj->getTitle())
                ->setOrder($orderObj)
                ->setGoods($goodsObj)
                ->setBuyCount($this->num)
                ->setCoverImg($goodsObj->getCoverImg())
                ->setAddTime(date('Y-m-d H:i:s', time()))
                ->save();
        } else {
            $orderGoodsObj = new OrderGoods();
            $orderGoodsObj
                ->setAttrBrief($productObj->getGoodsAttr())
                ->setGoodsTitle($goodsObj->getTitle())
                ->setOrder($orderObj)
                ->setGoods($goodsObj)
                ->setProduct($productObj)
                ->setCoverImg($productObj->getCoverImg())
                ->setBuyCount($this->num)
                ->setAddTime(date('Y-m-d H:i:s', time()))
                ->save();
        }
    }
}