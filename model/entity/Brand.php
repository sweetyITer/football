<?php

namespace model\entity;
use model\footballModel;

/**
 * Brand
 */
class Brand extends footballModel
{
    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $logo = '';

    /**
     * @var string
     */
    private $brief;

    /**
     * @var string
     */
    private $siteUrl = '';

    /**
     * @var integer
     */
    private $orderNum = '50';

    /**
     * @var boolean
     */
    private $isShow = true;

    /**
     * @var boolean
     */
    private $isDelete = false;

    /**
     * @var string
     */
    private $addTime = '0000-00-00 00:00:00';

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Brand
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
     * Set logo
     *
     * @param string $logo
     *
     * @return Brand
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set brief
     *
     * @param string $brief
     *
     * @return Brand
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
     * Set siteUrl
     *
     * @param string $siteUrl
     *
     * @return Brand
     */
    public function setSiteUrl($siteUrl)
    {
        $this->siteUrl = $siteUrl;

        return $this;
    }

    /**
     * Get siteUrl
     *
     * @return string
     */
    public function getSiteUrl()
    {
        return $this->siteUrl;
    }

    /**
     * Set orderNum
     *
     * @param integer $orderNum
     *
     * @return Brand
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
     * Set isShow
     *
     * @param boolean $isShow
     *
     * @return Brand
     */
    public function setIsShow($isShow)
    {
        $this->isShow = $isShow == true;

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
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Brand
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete == true;

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
     * @return Brand
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

