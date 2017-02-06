<?php

namespace model\entity;
use model\footballModel;

/**
 * OrderRefund
 */
class OrderRefund extends footballModel
{
    /**
     * @var string
     */
    private $outTradeNo;

    /**
     * @var string
     */
    private $refundType = 'refund_all';

    /**
     * @var string
     */
    private $refuseReason;

    /**
     * @var string
     */
    private $refundRemark;

    /**
     * @var string
     */
    private $refundMoney;

    /**
     * @var string
     */
    private $status = 'applyed';

    /**
     * @var string
     */
    private $ext;

    /**
     * @var \DateTime
     */
    private $updateTime = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\Order
     */
    private $order;

    /**
     * @var \model\entity\Goods
     */
    private $goods;


    /**
     * Set outTradeNo
     *
     * @param string $outTradeNo
     *
     * @return OrderRefund
     */
    public function setOutTradeNo($outTradeNo)
    {
        $this->outTradeNo = $outTradeNo;

        return $this;
    }

    /**
     * Get outTradeNo
     *
     * @return string
     */
    public function getOutTradeNo()
    {
        return $this->outTradeNo;
    }

    /**
     * Set refundType
     *
     * @param string $refundType
     *
     * @return OrderRefund
     */
    public function setRefundType($refundType)
    {
        $this->refundType = $refundType;

        return $this;
    }

    /**
     * Get refundType
     *
     * @return string
     */
    public function getRefundType()
    {
        return $this->refundType;
    }

    /**
     * Set refuseReason
     *
     * @param string $refuseReason
     *
     * @return OrderRefund
     */
    public function setRefuseReason($refuseReason)
    {
        $this->refuseReason = $refuseReason;

        return $this;
    }

    /**
     * Get refuseReason
     *
     * @return string
     */
    public function getRefuseReason()
    {
        return $this->refuseReason;
    }

    /**
     * Set refundRemark
     *
     * @param string $refundRemark
     *
     * @return OrderRefund
     */
    public function setRefundRemark($refundRemark)
    {
        $this->refundRemark = $refundRemark;

        return $this;
    }

    /**
     * Get refundRemark
     *
     * @return string
     */
    public function getRefundRemark()
    {
        return $this->refundRemark;
    }

    /**
     * Set refundMoney
     *
     * @param string $refundMoney
     *
     * @return OrderRefund
     */
    public function setRefundMoney($refundMoney)
    {
        $this->refundMoney = $refundMoney;

        return $this;
    }

    /**
     * Get refundMoney
     *
     * @return string
     */
    public function getRefundMoney()
    {
        return $this->refundMoney;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return OrderRefund
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set ext
     *
     * @param string $ext
     *
     * @return OrderRefund
     */
    public function setExt($ext)
    {
        $this->ext = $ext;

        return $this;
    }

    /**
     * Get ext
     *
     * @return string
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * Set updateTime
     *
     * @param \DateTime $updateTime
     *
     * @return OrderRefund
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return \DateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return OrderRefund
     */
    public function setAddTime($addTime)
    {
        $this->addTime = $addTime;

        return $this;
    }

    /**
     * Get addTime
     *
     * @return string
     */
    public function getAddTime()
    {
        return $this->addTime;
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
     * Set order
     *
     * @param \model\entity\Order $order
     *
     * @return OrderRefund
     */
    public function setOrder(\model\entity\Order $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \model\entity\Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set goods
     *
     * @param \model\entity\Goods $goods
     *
     * @return OrderRefund
     */
    public function setGoods(\model\entity\Goods $goods = null)
    {
        $this->goods = $goods;

        return $this;
    }

    /**
     * Get goods
     *
     * @return \model\entity\Goods
     */
    public function getGoods()
    {
        return $this->goods;
    }
}

