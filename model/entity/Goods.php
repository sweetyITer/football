<?php

namespace model\entity;

use mmapi\core\AppException;
use mmapi\core\Db;
use mmapi\core\Model;
use model\footballModel;
use model\entity\GoodsGallery;

/**
 * Goods
 */
class Goods extends Model
{
    /**
     * @var string
     */
    private $goodsSn;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $subTitle = '';

    /**
     * @var string
     */
    private $brief = '';

    /**
     * @var string
     */
    private $originalPrice;

    /**
     * @var string
     */
    private $currentPrice;

    /**
     * @var integer
     */
    private $weight = '0';

    /**
     * @var string
     */
    private $transportFee = '0.00';

    /**
     * @var string
     */
    private $keywords = '';

    /**
     * @var string
     */
    private $tagStr = '';

    /**
     * @var boolean
     */
    private $isDelete = false;

    /**
     * @var boolean
     */
    private $isBest = false;

    /**
     * @var integer
     */
    private $likeCount = '0';

    /**
     * @var integer
     */
    private $commentCount = '0';

    /**
     * @var integer
     */
    private $soldCount = '0';

    /**
     * @var integer
     */
    private $views = '0';

    /**
     * @var string
     */
    private $note = '';

    /**
     * @var integer
     */
    private $stock = '0';

    /**
     * @var boolean
     */
    private $isOnSale = true;

    /**
     * @var string
     */
    private $goodsFrom = '';

    /**
     * @var string
     */
    private $auditStatus = 'wait';

    /**
     * @var \DateTime
     */
    private $updateTime;

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\AttributeSet
     */
    private $attributeSet;

    /**
     * @var \model\entity\GoodsGallery
     */
    private $coverImg;

    /**
     * @var \model\entity\Brand
     */
    private $brand;

    /**
     * @var \model\entity\Category
     */
    private $cid;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $tag;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tag     = new \Doctrine\Common\Collections\ArrayCollection();
        $this->addTime = date('Y-m-d H:i:s');
    }

    /**
     * Set goodSn
     *
     * @param string $goodsSn
     *
     * @return Goods
     * @throws AppException
     */
    public function setGoodsSn($goodsSn)
    {
        $this->goodsSn = $goodsSn;
        /** @var Goods $obj */
        $obj = Goods::getRepository()->findOneBy(['goodsSn' => $this->goodsSn]);
        if ($obj && $obj->getId() != $this->id) {
            throw new AppException("商品编码已经存在，请更换", 'GOODS_SN_DUPLICATE');
        }

        return $this;
    }

    /**
     * Get goodSn
     *
     * @return string
     */
    public function getGoodsSn()
    {
        return $this->goodsSn;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Goods
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subTitle
     *
     * @param string $subTitle
     *
     * @return Goods
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    /**
     * Get subTitle
     *
     * @return string
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }

    /**
     * Set brief
     *
     * @param string $brief
     *
     * @return Goods
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
     * Set originalPrice
     *
     * @param string $originalPrice
     *
     * @return Goods
     */
    public function setOriginalPrice($originalPrice)
    {
        $this->originalPrice = sprintf('%.2f', $originalPrice);

        return $this;
    }

    /**
     * Get originalPrice
     *
     * @return string
     */
    public function getOriginalPrice()
    {
        return $this->originalPrice;
    }

    /**
     * Set currentPrice
     *
     * @param string $currentPrice
     *
     * @return Goods
     */
    public function setCurrentPrice($currentPrice)
    {
        $this->currentPrice = sprintf('%.2f', $currentPrice);

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
     * Set weight
     *
     * @param integer $weight
     *
     * @return Goods
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set transportFee
     *
     * @param string $transportFee
     *
     * @return Goods
     */
    public function setTransportFee($transportFee)
    {
        $this->transportFee = $transportFee;

        return $this;
    }

    /**
     * Get transportFee
     *
     * @return string
     */
    public function getTransportFee()
    {
        return $this->transportFee;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     *
     * @return Goods
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set tagStr
     *
     * @param string $tagStr
     *
     * @return Goods
     */
    public function setTagStr($tagStr)
    {
        $this->tagStr = $tagStr;

        return $this;
    }

    /**
     * Get tagStr
     *
     * @return string
     */
    public function getTagStr()
    {
        return $this->tagStr;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Goods
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
        return $this->isDelete == 1 ? true : false;
    }

    /**
     * Set isBest
     *
     * @param boolean $isBest
     *
     * @return Goods
     */
    public function setIsBest($isBest)
    {
        $this->isBest = $isBest == true;

        return $this;
    }

    /**
     * Get isBest
     *
     * @return boolean
     */
    public function isBest()
    {
        return $this->isBest;
    }

    /**
     * Set likeCount
     *
     * @param integer $likeCount
     *
     * @return Goods
     */
    public function setLikeCount($likeCount)
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    /**
     * Get likeCount
     *
     * @return integer
     */
    public function getLikeCount()
    {
        return $this->likeCount;
    }

    /**
     * Set commentCount
     *
     * @param integer $commentCount
     *
     * @return Goods
     */
    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;

        return $this;
    }

    /**
     * Get commentCount
     *
     * @return integer
     */
    public function getCommentCount()
    {
        return $this->commentCount;
    }

    /**
     * Set soldCount
     *
     * @param integer $soldCount
     *
     * @return Goods
     */
    public function setSoldCount($soldCount)
    {
        $this->soldCount = $soldCount;

        return $this;
    }

    /**
     * Get soldCount
     *
     * @return integer
     */
    public function getSoldCount()
    {
        return $this->soldCount;
    }

    /**
     * Set views
     *
     * @param integer $views
     *
     * @return Goods
     */
    public function setViews($views)
    {
        $this->views = $views;

        return $this;
    }

    /**
     * Get views
     *
     * @return integer
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Goods
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set stock
     *
     * @param integer $stock
     *
     * @return Goods
     */
    public function setStock($stock)
    {
        $this->stock = $stock;

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
     * Set isOnSale
     *
     * @param boolean $isOnSale
     *
     * @return Goods
     */
    public function setIsOnSale($isOnSale)
    {
        $this->isOnSale = $isOnSale;

        return $this;
    }

    /**
     * Get isOnSale
     *
     * @return boolean
     */
    public function isOnSale()
    {
        return $this->isOnSale;
    }

    /**
     * Set goodsFrom
     *
     * @param string $goodsFrom
     *
     * @return Goods
     */
    public function setGoodsFrom($goodsFrom)
    {
        $this->goodsFrom = $goodsFrom;

        return $this;
    }

    /**
     * Get goodsFrom
     *
     * @return string
     */
    public function getGoodsFrom()
    {
        return $this->goodsFrom;
    }

    /**
     * Set auditStatus
     *
     * @param string $auditStatus
     *
     * @return Goods
     */
    public function setAuditStatus($auditStatus)
    {
        $this->auditStatus = $auditStatus;

        return $this;
    }

    /**
     * Get auditStatus
     *
     * @return string
     */
    public function getAuditStatus()
    {
        return $this->auditStatus;
    }

    /**
     * Set updateTime
     *
     * @param \DateTime $updateTime
     *
     * @return Goods
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
     * @return Goods
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
     * Set attributeSet
     *
     * @param \model\entity\AttributeSet $attributeSet
     *
     * @return Goods
     */
    public function setAttributeSet(\model\entity\AttributeSet $attributeSet = null)
    {
        $this->attributeSet = $attributeSet;

        return $this;
    }

    /**
     * Get attributeSet
     *
     * @return \model\entity\AttributeSet
     */
    public function getAttributeSet()
    {
        return $this->attributeSet;
    }

    /**
     * Set coverImg
     *
     * @param \model\entity\GoodsGallery $coverImg
     *
     * @return Goods
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
     * Set brand
     *
     * @param \model\entity\Brand $brand
     *
     * @return Goods
     */
    public function setBrand(\model\entity\Brand $brand = null)
    {
        if (!($brand instanceof Brand)) {
            throw new AppException("商品品牌非法", 'BRAND_INVALID');
        }
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return \model\entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set cid
     *
     * @param \model\entity\Category $cid
     *
     * @return Goods
     */
    public function setCid(\model\entity\Category $cid)
    {
        if (!($cid instanceof Category)) {
            throw new AppException("商品分类非法", 'CATEGORY_INVALID');
        }
        $this->cid = $cid;

        return $this;
    }

    /**
     * Get cid
     *
     * @return \model\entity\Category
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * Add user
     *
     * @param \model\entity\User $user
     *
     * @return Goods
     */
    public function addUser(\model\entity\User $user)
    {
        if (!($user instanceof User)) {
            throw new AppException("用户不存在", 'USER_INVALID');
        }
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \model\entity\User $user
     */
    public function removeUser(\model\entity\User $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get user
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add tag
     *
     * @param \model\entity\Tag $tag
     *
     * @return Goods
     */
    public function addTag(\model\entity\Tag $tag)
    {
        $this->tag[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \model\entity\Tag $tag
     */
    public function removeTag(\model\entity\Tag $tag)
    {
        $this->tag->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @desc   createSn 随机生成商品编码
     * @author chenmingming
     * @return string
     */
    static public function createSn()
    {
        return 'G' . date('YmdHis') . mt_rand(10, 99) . mt_rand(10, 99);
    }

    /**
     * @desc   getProductObjs 获取sku商品对象数组
     * @author chenmingming
     *
     * @return array
     */
    public function getProductObjs()
    {
        return Product::getRepository()->findBy(['goods' => $this, 'isDelete' => 0]);
    }

    /**
     * @desc   getProductsArray 获取sku商品详情数组
     * @author chenmingming
     *
     *
     * @return array
     */
    public function getProductsArray()
    {
        $products = [];
        /** @var Product $pro */
        foreach ($this->getProductObjs() as $pro) {
            $product = [
                'id'         => $pro->getId(),
                'product_sn' => $pro->getProductSn(),
                'stock'      => $pro->getStock(),
                'price'      => $pro->getPrice(),
                'key'        => $pro->getKey(),
                'brief'      => implode("、", $pro->getStyleTextArray()),
                'style'      => $pro->getStyleTextArray(),
            ];
            if (is_null($pro->getCoverImg())) {
                $product['cover_img_id']  = 0;
                $product['cover_img_url'] = '';
            } else {
                $product['cover_img_id']  = $pro->getCoverImg()->getId();
                $product['cover_img_url'] = $pro->getCoverImg()->getUrl();
            }
            array_push($products, $product);
        }

        return $products;
    }

    /**
     * @desc   getAttrObjs 获取属性对象数组
     * @author chenmingming
     * @return array
     */
    public function getAttrObjs()
    {
        return GoodsAttr::getRepository()->findBy(['goods' => $this, 'isDelete' => 0]);
    }

    /**
     * @desc   getAttrList 获取商品属性列表  [id:'商品属性关系id','value'=>'该属性值']
     * @author chenmingming
     * @return array
     */
    public function getAttrIndexList()
    {
        $goodsAttrObjs      = $this->getAttrObjs();
        $attrsSelectedArray = [];
        /** @var GoodsAttr $goodsAttrObj */
        foreach ($goodsAttrObjs as $goodsAttrObj) {
            $attrsSelectedArray[$goodsAttrObj->getAttr()->getId()][$goodsAttrObj->getId()] = $goodsAttrObj->getAttrValue();
        }

        return $attrsSelectedArray;
    }

    /**
     * @desc   getAttrList 获取属性列表
     * @author chenmingming
     * @return array
     */
    public function getAttrList()
    {
        $goodsAttrObjs = $this->getAttrObjs();
        $list          = [];
        /** @var GoodsAttr $goodsAttrObj */
        foreach ($goodsAttrObjs as $goodsAttrObj) {
            $list[] = [
                'id'     => $goodsAttrObj->getId(),
                'value'  => $goodsAttrObj->getAttrValue(),
                'attrId' => $goodsAttrObj->getAttr()->getId(),
            ];
        }

        return $list;
    }

    /**
     * @desc   deleteAllProduct
     * @author chenmingming
     */
    public function deleteAllProduct()
    {
        $this->getDb()->sqlBuilder()
            ->update('mall_product')
            ->set('is_delete')->value(1)
            ->where('goods_id')->eq($this->id)
            ->exec();
    }

    /**
     * getList @desc 商品列表
     *
     * @author wangjuan
     *
     * @param int $cid  分类id
     * @param int $page 页数
     * @param int $size 每页显示数量
     *
     * @return array
     */
    static public function getList($cid, $page, $size)
    {
        $data = Db::create()->sqlBuilder()
            ->select('id, title, sold_count, cover_img_id, current_price')
            ->from('mall_goods')
            ->where('is_on_sale')
            ->eq(1)
            /*   ->andWhere('audit_status')
               ->eq('audited')*/
            ->andWhere('cid')
            ->eq($cid)
            ->andWhere('is_delete')
            ->eq(0)
            ->limit(($page - 1) * $size, $size)
            ->fetchAll();
        $list = [];
        foreach ($data as $v) {
            /** @var  Goods $goodsObj */
            $goodsObj = Goods::getInstance($v['id']);
            $list[]   = [
                'id'            => $v['id'],
                'title'         => $v['title'],
                'sold_count'    => $v['sold_count'],
                'current_price' => $v['current_price'],
                'is_hot'        => $v['id'] == Goods::isHot($cid) ? true : false,
                'is_newest'     => $v['id'] == Goods::isNewest($cid) ? true : false,
                'pic_url'       => $goodsObj->getCoverImg() ? $goodsObj->getCoverImg()->getUrl() : '',
            ];
        }

        return $list;
    }

    /**
     *
     * isHot @desc 获取最火的商品的id
     *
     * @author wangjuan
     *
     * @param $cid
     *
     * @return int
     */
    static public function isHot($cid)
    {
        return (int)Db::create()->sqlBuilder()
            ->select('max(sold_count) as m_sold_count, id')
            ->from('mall_goods')
            ->where('is_on_sale')
            ->eq(1)
            /*   ->andWhere('audit_status')
          ->eq('audited')*/
            ->andWhere('cid')
            ->eq($cid)
            ->andWhere('is_delete')
            ->eq(0)
            ->getField('id');

    }

    /**
     * isNewest @desc 获取最新上架的商品id
     *
     * @author wangjuan
     *
     * @param $cid
     *
     * @return int
     */
    static public function isNewest($cid)
    {
        return (int)Db::create()->sqlBuilder()
            ->select('id')
            ->from('mall_goods')
            ->where('is_on_sale')
            ->eq(1)
            /*   ->andWhere('audit_status')
           ->eq('audited')*/
            ->andWhere('cid')
            ->eq($cid)
            ->andWhere('is_delete')
            ->eq(0)
            ->order('update_time desc')
            ->limit(0, 1)
            ->getField('id');
    }
}



