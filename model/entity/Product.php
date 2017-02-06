<?php

namespace model\entity;

use mmapi\api\ApiException;
use model\footballModel;

/**
 * Product
 */
class Product extends footballModel
{
    /**
     * @var string
     */
    private $productSn;

    /**
     * @var integer
     */
    private $stock = '0';

    /**
     * @var string
     */
    private $price = '0.00';

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
     * @var \model\entity\GoodsGallery
     */
    private $coverImg;

    /**
     * @var \model\entity\Goods
     */
    private $goods;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $goodsAttr;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->goodsAttr = new \Doctrine\Common\Collections\ArrayCollection();
        $this->addTime   = date('Y-m-d H:i:s');
    }

    /**
     * Set productSn
     *
     * @param string $productSn
     *
     * @return Product
     */
    public function setProductSn($productSn)
    {
        $this->productSn = $productSn;

        return $this;
    }

    /**
     * Get productSn
     *
     * @return string
     */
    public function getProductSn()
    {
        return $this->productSn;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Product
     */
    public function setStock($stock)
    {
        $this->stock = max((int)$stock, 0);

        return $this;
    }

    /**
     * Get stock
     *
     * @return integer
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set price
     *
     * @param float $price 价格
     *
     * @return Product
     * @throws ApiException
     */
    public function setPrice($price)
    {
        if ($price < 0) {
            throw new ApiException("差价不能小于0");
        }
        $this->price = sprintf('%.2f', $price);

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * Set goods
     *
     * @param \model\entity\Goods $goods
     *
     * @return Product
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
     * Add goodsAttr
     *
     * @param \model\entity\GoodsAttr $goodsAttr
     *
     * @return Product
     */
    public function addGoodsAttr(\model\entity\GoodsAttr $goodsAttr)
    {
        $this->goodsAttr[] = $goodsAttr;

        return $this;
    }

    /**
     * Remove goodsAttr
     *
     * @param \model\entity\GoodsAttr $goodsAttr
     */
    public function removeGoodsAttr(\model\entity\GoodsAttr $goodsAttr)
    {
        $this->goodsAttr->removeElement($goodsAttr);
    }

    /**
     * Get goodsAttr
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGoodsAttr()
    {
        return $this->goodsAttr;
    }

    /**
     * @desc   getKey 商品款式key 款式id 字符串 -分隔
     * @author chenmingming
     * @return string
     */
    public function getKey()
    {
        /** @var GoodsAttr $attr */
        foreach ($this->getGoodsAttr() as $attr) {
            $attrList[$attr->getAttr()->getId()] = $attr->getId();
        }
        ksort($attrList);

        return implode('-', array_values($attrList));
    }

    /**
     * @desc   getStyleText 获取某个sku商品的款式的名称
     * @author chenmingming
     * @return string
     */
    public function getStyleTextArray()
    {
        /** @var GoodsAttr $attr */
        foreach ($this->getGoodsAttr() as $attr) {
            $attrList[$attr->getAttr()->getId()] = $attr->getAttrValue();
        }
        ksort($attrList);

        return array_values($attrList);
    }
}

