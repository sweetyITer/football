<?php

namespace model\entity;
use model\footballModel;

/**
 * Region
 */
class Region extends footballModel
{
    /**
     * @var integer
     */
    private $parentId = '0';

    /**
     * @var string
     */
    private $regionName = '';

    /**
     * @var int
     */
    private $regionType = '2';

    /**
     * @var integer
     */
    private $agencyId = '0';

    /**
     * @var boolean
     */
    private $status = '1';

    /**
     * @var integer
     */
    private $orderNum = '1000';

    /**
     * @var integer
     */
    private $regionId;


    /**
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return Region
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set regionName
     *
     * @param string $regionName
     *
     * @return Region
     */
    public function setRegionName($regionName)
    {
        $this->regionName = $regionName;

        return $this;
    }

    /**
     * Get regionName
     *
     * @return string
     */
    public function getRegionName()
    {
        return $this->regionName;
    }

    /**
     * Set regionType
     *
     * @param int $regionType
     *
     * @return Region
     */
    public function setRegionType($regionType)
    {
        $this->regionType = $regionType;

        return $this;
    }

    /**
     * Get regionType
     *
     * @return boolean
     */
    public function getRegionType()
    {
        return $this->regionType;
    }

    /**
     * Set agencyId
     *
     * @param integer $agencyId
     *
     * @return Region
     */
    public function setAgencyId($agencyId)
    {
        $this->agencyId = $agencyId;

        return $this;
    }

    /**
     * Get agencyId
     *
     * @return integer
     */
    public function getAgencyId()
    {
        return $this->agencyId;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Region
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set orderNum
     *
     * @param integer $orderNum
     *
     * @return Region
     */
    public function setOrderNum($orderNum)
    {
        $this->orderNum = $orderNum;

        return $this;
    }

    /**
     * Get orderNum
     *
     * @return integer
     */
    public function getOrderNum()
    {
        return $this->orderNum;
    }

    /**
     * Get regionId
     *
     * @return integer
     */
    public function getRegionId()
    {
        return $this->regionId;
    }
}

