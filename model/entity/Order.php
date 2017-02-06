<?php

namespace model\entity;

use app\api\Login\login;
use mmapi\core\Log;
use model\footballModel;

/**
 * Order
 */
class Order extends footballModel
{
    /**
     * @var string
     */
    private $orderSn = '';

    /**
     * @var integer
     */
    private $shopId = '0';

    /**
     * @var string
     */
    private $orderStatus = 'wait_confirm';

    /**
     * @var string
     */
    private $shippingStatus = 'wait';

    /**
     * @var string
     */
    private $payStatus = 'not_pay';

    /**
     * @var string
     */
    private $payWay = 'alipay';

    /**
     * @var string
     */
    private $goodsAmount = '0.00';

    /**
     * @var string
     */
    private $payFee = '0.00';

    /**
     * @var string
     */
    private $createTime = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    private $payTime = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    private $shippingTime = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    private $invoiceName = '';

    /**
     * @var string
     */
    private $invoiceNo = '';

    /**
     * @var string
     */
    private $userRemark = '';

    /**
     * @var string
     */
    private $adminRemark = '';

    /**
     * @var boolean
     */
    private $isDelete = false;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\User
     */
    private $user;

    const ALIPAY = 'alipay';

    const WXPAY = 'wexin';

    const IOS = "ios";

    const ANDROID = 'android';

    /**
     * Constructor
     */
    /*   public function __construct()
       {
           $this->createTime = date('Y-m-d H:i:s',time());
       }*/

    /**
     * setOrderSn @desc
     *
     * @author wangjuan
     *
     * @param $payWay
     * @param $from
     *
     * @return $this
     */
    public function setOrderSn($payWay, $from)
    {
        Log::alert("132");
        $this->orderSn = $this->createOrderSn($payWay, $from);
            //$this->createOrderSn($payWay, $from);

        return $this;
    }

    /**
     * createOrderSn @desc 创建订单号
     *
     * @author wangjuan
     *
     * @param string $payType
     * @param string $from
     *
     * @return string
     */
    static private function createOrderSn($payType = self::ALIPAY, $from = self::IOS)
    {
        $type = 'A';
        if ($payType == self::WXPAY) {
            $type = 'W';
        }
        switch ($from) {
            case self::IOS:
                $pre = 'I';
                break;
            case self::ANDROID:
                $pre = 'A';
                break;
            default:
                $pre = 'I';
        }

        return $pre . $type . date('YmdHis') . mt_rand(10, 99) . mt_rand(0, 9) . mt_rand(0, 9);
    }

    /**
     * Get orderSn
     *
     * @return string
     */
    public function getOrderSn()
    {
        return $this->orderSn;
    }

    /**
     * Set shopId
     *
     * @param integer $shopId
     *
     * @return Order
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * Get shopId
     *
     * @return integer
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * Set orderStatus
     *
     * @param string $orderStatus
     *
     * @return Order
     */
    public function setOrderStatus($orderStatus)
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    /**
     * Get orderStatus
     *
     * @return string
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * Set shippingStatus
     *
     * @param string $shippingStatus
     *
     * @return Order
     */
    public function setShippingStatus($shippingStatus)
    {
        $this->shippingStatus = $shippingStatus;

        return $this;
    }

    /**
     * Get shippingStatus
     *
     * @return string
     */
    public function getShippingStatus()
    {
        return $this->shippingStatus;
    }

    /**
     * Set payStatus
     *
     * @param string $payStatus
     *
     * @return Order
     */
    public function setPayStatus($payStatus)
    {
        $this->payStatus = $payStatus;

        return $this;
    }

    /**
     * Get payStatus
     *
     * @return string
     */
    public function getPayStatus()
    {
        return $this->payStatus;
    }

    /**
     * Set payWay
     *
     * @param string $payWay
     *
     * @return Order
     */
    public function setPayWay($payWay)
    {
        $this->payWay = $payWay;

        return $this;
    }

    /**
     * Get payWay
     *
     * @return string
     */
    public function getPayWay()
    {
        return $this->payWay;
    }

    /**
     * Set goodsAmount
     *
     * @param string $goodsAmount
     *
     * @return Order
     */
    public function setGoodsAmount($goodsAmount)
    {
        $this->goodsAmount = $goodsAmount;

        return $this;
    }

    /**
     * Get goodsAmount
     *
     * @return string
     */
    public function getGoodsAmount()
    {
        return $this->goodsAmount;
    }

    /**
     * Set payFee
     *
     * @param string $payFee
     *
     * @return Order
     */
    public function setPayFee($payFee)
    {
        $this->payFee = $payFee;

        return $this;
    }

    /**
     * Get payFee
     *
     * @return string
     */
    public function getPayFee()
    {
        return $this->payFee;
    }

    /**
     * Set createTime
     *
     * @param string $createTime
     *
     * @return Order
     */
    public function setCreateTime($createTime)
    {
        $this->createTime = $createTime;

        return $this;
    }

    /**
     * Get createTime
     *
     * @return string
     */
    public function getCreateTime()
    {
        return $this->createTime;
    }

    /**
     * Set payTime
     *
     * @param string $payTime
     *
     * @return Order
     */
    public function setPayTime($payTime)
    {
        $this->payTime = $payTime;

        return $this;
    }

    /**
     * Get payTime
     *
     * @return string
     */
    public function getPayTime()
    {
        return $this->payTime;
    }

    /**
     * Set shippingTime
     *
     * @param string $shippingTime
     *
     * @return Order
     */
    public function setShippingTime($shippingTime)
    {
        $this->shippingTime = $shippingTime;

        return $this;
    }

    /**
     * Get shippingTime
     *
     * @return string
     */
    public function getShippingTime()
    {
        return $this->shippingTime;
    }

    /**
     * Set invoiceName
     *
     * @param string $invoiceName
     *
     * @return Order
     */
    public function setInvoiceName($invoiceName)
    {
        $this->invoiceName = $invoiceName;

        return $this;
    }

    /**
     * Get invoiceName
     *
     * @return string
     */
    public function getInvoiceName()
    {
        return $this->invoiceName;
    }

    /**
     * Set invoiceNo
     *
     * @param string $invoiceNo
     *
     * @return Order
     */
    public function setInvoiceNo($invoiceNo)
    {
        $this->invoiceNo = $invoiceNo;

        return $this;
    }

    /**
     * Get invoiceNo
     *
     * @return string
     */
    public function getInvoiceNo()
    {
        return $this->invoiceNo;
    }

    /**
     * Set userRemark
     *
     * @param string $userRemark
     *
     * @return Order
     */
    public function setUserRemark($userRemark)
    {
        $this->userRemark = $userRemark;

        return $this;
    }

    /**
     * Get userRemark
     *
     * @return string
     */
    public function getUserRemark()
    {
        return $this->userRemark;
    }

    /**
     * Set adminRemark
     *
     * @param string $adminRemark
     *
     * @return Order
     */
    public function setAdminRemark($adminRemark)
    {
        $this->adminRemark = $adminRemark;

        return $this;
    }

    /**
     * Get adminRemark
     *
     * @return string
     */
    public function getAdminRemark()
    {
        return $this->adminRemark;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Order
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete == true ? 1 : 0;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function isDelete()
    {
        return $this->isDelete;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \model\entity\User $user
     *
     * @return Order
     */
    public function setUser(\model\entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \model\entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

}

