<?php

namespace model\entity;

use mmapi\core\Model;
use model\footballModel;

/**
 * GoodsAttr
 */
class GoodsAttr extends Model
{
    /**
     * @var string
     */
    private $attrValue;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\Attribute
     */
    private $attr;

    /**
     * @var \model\entity\Goods
     */
    private $goods;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $product;

    /**
     * @var int
     */
    private $isDelete = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set attrValue
     *
     * @param string $attrValue
     *
     * @return GoodsAttr
     */
    public function setAttrValue($attrValue)
    {
        $this->attrValue = $attrValue;

        return $this;
    }

    /**
     * Get attrValue
     *
     * @return string
     */
    public function getAttrValue()
    {
        return $this->attrValue;
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
     * Set attr
     *
     * @param \model\entity\Attribute $attr
     *
     * @return GoodsAttr
     */
    public function setAttr(\model\entity\Attribute $attr = null)
    {
        $this->attr = $attr;

        return $this;
    }

    /**
     * Get attr
     *
     * @return \model\entity\Attribute
     */
    public function getAttr()
    {
        return $this->attr;
    }

    /**
     * Set goods
     *
     * @param \model\entity\Goods $goods
     *
     * @return GoodsAttr
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
     * Add product
     *
     * @param \model\entity\Product $product
     *
     * @return GoodsAttr
     */
    public function addProduct(\model\entity\Product $product)
    {
        $this->product[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \model\entity\Product $product
     */
    public function removeProduct(\model\entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @return int
     */
    public function isDelete()
    {
        return $this->isDelete == true;
    }

    /**
     * @param int $isDelete
     *
     * @return GoodsAttr
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete == true;

        return $this;
    }

    /**
     * @desc   getAttrList 获取该商品的款式列表详情
     * @author chenmingming
     *
     * @param Goods $goodsObj 商品对象
     *
     * @return array
     */
    static public function getAttrList(Goods $goodsObj)
    {
        $attrsArray        = $attrsSelectedArray = [];
        $goodsAttrObjs     = GoodsAttr::getRepository()->findBy(['goods' => $goodsObj]);
        $attributeObjArray = [];
        /** @var GoodsAttr $goodsAttrObj */
        foreach ($goodsAttrObjs as $goodsAttrObj) {
            !in_array($goodsAttrObj->getAttr(), $attributeObjArray)
            && array_push($attributeObjArray, $goodsAttrObj->getAttr());

            $attrsSelectedArray[$goodsAttrObj->getAttr()->getId()][$goodsAttrObj->getId()] = $goodsAttrObj->getAttrValue();
        }
        /** @var Attribute $attribute */
        foreach ($attributeObjArray as $attribute) {
            $attrsArray[] = [
                'id'            => $attribute->getId(),
                'attrName'      => $attribute->getAttrName(),
                'attrInputType' => $attribute->getAttrInputType(),
                'valuesArray'   => $attribute->getValuesConfig($attrsSelectedArray[$attribute->getId()]),
            ];
        }

        return $attrsArray;
    }
}

