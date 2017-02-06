<?php

namespace model\entity;
use model\footballModel;

/**
 * Tag
 */
class Tag extends footballModel
{
    /**
     * @var string
     */
    private $text;

    /**
     * @var integer
     */
    private $useCount = '0';

    /**
     * @var string
     */
    private $addTime = '0000-00-00 00:00:00';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $goods;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->goods = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Tag
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set useCount
     *
     * @param integer $useCount
     *
     * @return Tag
     */
    public function setUseCount($useCount)
    {
        $this->useCount = $useCount;

        return $this;
    }

    /**
     * Get useCount
     *
     * @return integer
     */
    public function getUseCount()
    {
        return $this->useCount;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return Tag
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
     * Add good
     *
     * @param \model\entity\Goods $good
     *
     * @return Tag
     */
    public function addGood(\model\entity\Goods $good)
    {
        $this->goods[] = $good;

        return $this;
    }

    /**
     * Remove good
     *
     * @param \model\entity\Goods $good
     */
    public function removeGood(\model\entity\Goods $good)
    {
        $this->goods->removeElement($good);
    }

    /**
     * Get goods
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGoods()
    {
        return $this->goods;
    }
}

