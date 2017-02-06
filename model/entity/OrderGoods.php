<?php

namespace model\entity;
use model\footballModel;

/**
 * OrderGoods
 */
class OrderGoods extends footballModel
{
    /**
     * @var string
     */
    private $attrBrief;

    /**
     * @var string
     */
    private $goodsTitle;

    /**
     * @var integer
     */
    private $buyCount = '1';

    /**
     * @var string
     */
    private $orginalPrice = '0.00';

    /**
     * @var string
     */
    private $currentPrice = '0.00';

    /**
     * @var boolean
     */
    private $isReal = '0';

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\GoodsGallery
     */
    private $coverImg;

    /**
     * @var \model\entity\Product
     */
    private $product;

    /**
     * @var \model\entity\Goods
     */
    private $goods;

    /**
     * @var \model\entity\Order
     */
    private $order;


    /**
     * Set attrBrief
     *
     * @param string $attrBrief
     *
     * @return OrderGoods
     */
    public function setAttrBrief($attrBrief)
    {
        $this->attrBrief = $attrBrief;

        return $this;
    }

    /**
     * Get attrBrief
     *
     * @return string
     */
    public function getAttrBrief()
    {
        return $this->attrBrief;
    }

    /**
     * Set goodsTitle
     *
     * @param string $goodsTitle
     *
     * @return OrderGoods
     */
    public function setGoodsTitle($goodsTitle)
    {
        $this->goodsTitle = $goodsTitle;

        return $this;
    }

    /**
     * Get goodsTitle
     *
     * @return string
     */
    public function getGoodsTitle()
    {
        return $this->goodsTitle;
    }

    /**
     * Set buyCount
     *
     * @param integer $buyCount
     *
     * @return OrderGoods
     */
    public function setBuyCount($buyCount)
    {
        $this->buyCount = $buyCount;

        return $this;
    }

    /**
     * Get buyCount
     *
     * @return integer
     */
    public function getBuyCount()
    {
        return $this->buyCount;
    }

    /**
     * Set orginalPrice
     *
     * @param string $orginalPrice
     *
     * @return OrderGoods
     */
    public function setOrginalPrice($orginalPrice)
    {
        $this->orginalPrice = $orginalPrice;

        return $this;
    }

    /**
     * Get orginalPrice
     *
     * @return string
     */
    public function getOrginalPrice()
    {
        return $this->orginalPrice;
    }

    /**
     * Set currentPrice
     *
     * @param string $currentPrice
     *
     * @return OrderGoods
     */
    public function setCurrentPrice($currentPrice)
    {
        $this->currentPrice = $currentPrice;

        return $this;
    }

    /**
     * Get currentPrice
     *
     * @return string
     */
    public function getCurrentPrice()
    {
        return $this->currentPrice;
    }

    /**
     * Set isReal
     *
     * @param boolean $isReal
     *
     * @return OrderGoods
     */
    public function setIsReal($isReal)
    {
        $this->isReal = $isReal;

        return $this;
    }

    /**
     * Get isReal
     *
     * @return boolean
     */
    public function getIsReal()
    {
        return $this->isReal;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return OrderGoods
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
     * Set coverImg
     *
     * @param \model\entity\GoodsGallery $coverImg
     *
     * @return OrderGoods
     */
    public function setCoverImg(\model\entity\GoodsGallery $coverImg = null)
    {
        $this->coverImg = $coverImg;

        return $this;
    }

    /**
     * Get coverImg
     *
     * @return \model\entity\GoodsGallery
     */
    public function getCoverImg()
    {
        return $this->coverImg;
    }

    /**
     * Set product
     *
     * @param \model\entity\Product $product
     *
     * @return OrderGoods
     */
    public function setProduct(\model\entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \model\entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set goods
     *
     * @param \model\entity\Goods $goods
     *
     * @return OrderGoods
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

    /**
     * Set order
     *
     * @param \model\entity\Order $order
     *
     * @return OrderGoods
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
}

