<?php

namespace model\entity;

/**
 * CouponUser
 */
class CouponUser
{
    /**
     * @var integer
     */
    private $couponId;

    /**
     * @var string
     */
    private $couponNum;

    /**
     * @var integer
     */
    private $status = '1';

    /**
     * @var integer
     */
    private $userId = '0';

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set couponId
     *
     * @param integer $couponId
     *
     * @return CouponUser
     */
    public function setCouponId($couponId)
    {
        $this->couponId = $couponId;

        return $this;
    }

    /**
     * Get couponId
     *
     * @return integer
     */
    public function getCouponId()
    {
        return $this->couponId;
    }

    /**
     * Set couponNum
     *
     * @param string $couponNum
     *
     * @return CouponUser
     */
    public function setCouponNum($couponNum)
    {
        $this->couponNum = $couponNum;

        return $this;
    }

    /**
     * Get couponNum
     *
     * @return string
     */
    public function getCouponNum()
    {
        return $this->couponNum;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return CouponUser
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return CouponUser
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return CouponUser
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
}

