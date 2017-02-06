<?php

namespace model\entity;
use mmapi\core\Model;

/**
 * Category
 */
class Category extends Model
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $brief;

    /**
     * @var string
     */
    private $cover = '';

    /**
     * @var integer
     */
    private $pid = '0';

    /**
     * @var integer
     */
    private $rid = '0';

    /**
     * @var integer
     */
    private $orderNum = '0';

    /**
     * @var string
     */
    private $measureUnit;

    /**
     * @var boolean
     */
    private $isShow = true;

    /**
     * @var integer
     */
    private $goodsCount = '0';

    /**
     * @var boolean
     */
    private $isDelete = false;

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set brief
     *
     * @param string $brief
     *
     * @return Category
     */
    public function setBrief($brief)
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * Get brief
     *
     * @return string
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * Set cover
     *
     * @param string $cover
     *
     * @return Category
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     * Get cover
     *
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set pid
     *
     * @param integer $pid
     *
     * @return Category
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * Get pid
     *
     * @return integer
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set rid
     *
     * @param integer $rid
     *
     * @return Category
     */
    public function setRid($rid)
    {
        $this->rid = $rid;

        return $this;
    }

    /**
     * Get rid
     *
     * @return integer
     */
    public function getRid()
    {
        return $this->rid;
    }

    /**
     * Set orderNum
     *
     * @param integer $orderNum
     *
     * @return Category
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
     * Set measureUnit
     *
     * @param string $measureUnit
     *
     * @return Category
     */
    public function setMeasureUnit($measureUnit)
    {
        $this->measureUnit = $measureUnit;

        return $this;
    }

    /**
     * Get measureUnit
     *
     * @return string
     */
    public function getMeasureUnit()
    {
        return $this->measureUnit;
    }

    /**
     * Set isShow
     *
     * @param boolean $isShow
     *
     * @return Category
     */
    public function setIsShow($isShow)
    {
        $this->isShow = $isShow;

        return $this;
    }

    /**
     * Get isShow
     *
     * @return boolean
     */
    public function isShow()
    {
        return $this->isShow;
    }

    /**
     * Set goodsCount
     *
     * @param integer $goodsCount
     *
     * @return Category
     */
    public function setGoodsCount($goodsCount)
    {
        $this->goodsCount = $goodsCount;

        return $this;
    }

    /**
     * Get goodsCount
     *
     * @return integer
     */
    public function getGoodsCount()
    {
        return $this->goodsCount;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Category
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;

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
     * Set addTime
     *
     * @param string $addTime
     *
     * @return Category
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

