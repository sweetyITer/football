<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/8
 * Time: 14:12
 */

namespace app\admin\goods;

use app\AdminApi;
use Doctrine\Common\Collections\ArrayCollection;
use mmapi\api\ApiException;
use mmapi\core\App;
use mmapi\core\AppException;
use mmapi\core\Log;
use model\entity\Attribute;
use model\entity\AttributeSet;
use model\entity\Goods;
use model\entity\GoodsAttr;
use model\entity\GoodsGallery;
use model\entity\Product;

class updateProduct extends AdminApi
{
    /** @var  int 商品id */
    protected $goods_id;
    /**
     * @var int 属性集id
     */
    protected $attrset_id;

    protected $styles;
    /**
     * @var  string 款式商品信息json
     */
    protected $products;

    protected $attrObjList = [];

    protected $styleArray;

    /** @var  ArrayCollection */
    protected $AttrCollection;

    protected function init()
    {
        $this->addParams(['goods_id', 'attrset_id', 'styles', 'products']);
        $this->setDenyResubmitKey(['goods_id'], 'updateProducts');
    }

    public function run()
    {
        $this->db->getEntityManager()->getConnection()->beginTransaction();
        $this->AttrCollection = new ArrayCollection();
        /** @var Goods $goodsObj */
        $goodsObj = Goods::tryInstance($this->goods_id, new AppException('该商品不存在', 'GOODS_NOT_FUND'));
        /** @var AttributeSet $attrsetObj */
        $attrsetObj = AttributeSet::tryInstance($this->attrset_id, ['该属性集合不存在', 'ATTRIBUTE_NOT_FUND']);

        try {
            if (is_null($goodsObj->getAttributeSet())) {
                $this->addAttr($goodsObj);
            } else {
                $this->updateAttr($goodsObj);
            }
            $goodsObj->setAttributeSet($attrsetObj)
                ->save();
            $this->db->getEntityManager()->commit();
        } catch (\Exception $e) {
            $this->db->getEntityManager()->rollback();
            throw $e;
        }
        $this->set('data.id', $this->goods_id);
    }

    /**
     * @desc   add
     * @author chenmingming
     *
     * @param Goods $goodsObj 商品对象
     */
    protected function addAttr(Goods $goodsObj)
    {
        $nowAttrList = json_decode($this->styles, true);

        foreach ($nowAttrList as $item) {
            $attrObj = Attribute::tryInstance($item['attrId'], '属性不存在');
            $obj     = GoodsAttr::getRepository()->findOneBy(['goods' => $goodsObj, 'attr' => $attrObj, 'attrValue' => $item['value']]);
            if (is_null($obj)) {
                $obj = new GoodsAttr();
                $obj->setGoods($goodsObj)
                    ->setAttr($attrObj)
                    ->setAttrValue($item['value'])
                    ->save();
            }

            $key = $item['attrId'] . '-' . $item['value'];
            $this->AttrCollection->offsetSet(md5($key), $obj);
        }
        $this->updateProduct($goodsObj);
    }

    /**
     * @desc   addProduct 添加新的sku商品
     * @author chenmingming
     *
     * @param Goods $goodsObj 商品对象
     */
    protected function addProduct(Goods $goodsObj)
    {
        $products = json_decode($this->products, true);
        foreach ($products as $pro) {

            $product = new Product();
            $product
                ->setGoods($goodsObj)
                ->setPrice($pro['price'])
                ->setProductSn($pro['product_sn'])
                ->setStock($pro['stock']);

            $this->saveProductImg($product, $pro);
            $product->save();
            $this->parseProductAttrs($product, $pro['attrs']);
        }
    }

    /**
     * @desc   updateProduct 更新sku商品
     * @author chenmingming
     * @throws ApiException
     */
    protected function updateProduct(Goods $goodsObj)
    {
        $products = json_decode($this->products, true);
        foreach ($products as $pro) {
            if ($pro['id']) {
                /** @var Product $product */
                $product = Product::tryInstance($pro['id'], "sku商品不存在");
                if ($product->isDelete()) {
                    throw new ApiException("该款式商品已经被删除~");
                }
            } else {
                $product = new Product();
                $product->setGoods($goodsObj);
            }

            $product
                ->setPrice($pro['price'])
                ->setProductSn($pro['product_sn'])
                ->setStock($pro['stock']);

            $this->saveProductImg($product, $pro);
            $product->save();
        }
    }

    /**
     * @desc   update 更新商品属性信息
     * @author chenmingming
     *
     * @param Goods $goodsObj 商品对象
     */
    protected function updateAttr(Goods $goodsObj)
    {
        $nowAttrList = json_decode($this->styles, true);
        $oldAttrList = $goodsObj->getAttrList();
        list($needAdd, $needDel) = $this->diffAttr($nowAttrList, $oldAttrList);

        if (empty($needAdd) && empty($needDel)) {
            //属性没有更改过
            $this->updateProduct($goodsObj);

            return;
        }
        //删除所有sku商品
        $goodsObj->deleteAllProduct();
        //属性有更改过
        foreach ($needDel as $item) {
            //需要删除的attrId
            /** @var GoodsAttr $obj */
            $obj = GoodsAttr::tryInstance($item['id'], '商品属性不存在');
            $obj->setIsDelete(true)->save();
        }
        foreach ($needAdd as $item) {
            $obj = new GoodsAttr();
            $obj->setGoods($goodsObj)
                ->setAttr(Attribute::tryInstance($item['attrId'], '属性不存在'))
                ->setAttrValue($item['value'])
                ->save();
            $key = $item['attrId'] . '-' . $item['value'];
            $this->AttrCollection->offsetSet(md5($key), $obj);
        }
        foreach ($nowAttrList as $item) {
            if ($item['id'] <= 0) {
                continue;
            }
            $obj = GoodsAttr::tryInstance($item['id'], '商品属性不存在');
            $key = $item['attrId'] . '-' . $item['value'];

            $this->AttrCollection->offsetSet(md5($key), $obj);
        }
        $this->addProduct($goodsObj);
    }

    protected function diffAttr($nowAttrList, $oldAttrList)
    {
        if (empty($nowAttrList)) {
            if (empty($oldAttrList)) {
                return [[], []];
            } else {
                return [[], $oldAttrList];
            }
        } else {
            if (empty($oldAttrList)) {
                return [$nowAttrList, []];
            } else {
                foreach ($nowAttrList as &$a) ksort($a);
                foreach ($oldAttrList as &$b) ksort($b);
                $add = [];
                foreach ($nowAttrList as $c) {
                    if (!in_array($c, $oldAttrList)) {
                        array_push($add, $c);
                    }
                }
                $del = [];

                foreach ($oldAttrList as $d) {
                    if (!in_array($d, $nowAttrList)) {
                        array_push($del, $d);
                    }
                }

                return [$add, $del];
            }
        }
    }

    /**
     * @desc   saveProductImg 保存款式图片
     * @author chenmingming
     *
     * @param Product $product
     * @param         $pro
     */
    protected function saveProductImg(Product $product, $pro)
    {
        $imgObj = null;
        if ($pro['cover_img_id']) {
            /** @var GoodsGallery $imgObj */
            $imgObj = GoodsGallery::tryInstance($pro['cover_img_id'], ["该图片不存在", 'IMG_NOT_FUND']);
            if ($pro['img'] != $imgObj->getUrl()) {
                $imgObj = null;
            }
        }
        if (is_null($imgObj) && $pro['img']) {
            $imgObj = new GoodsGallery();
            $imgObj->setGoods($product->getGoods())
                ->setBrief($pro['brief'])
                ->setUrl($pro['img'])
                ->save();
        }
        $product->setCoverImg($imgObj);
    }

    /**
     * @desc   parseAttrs 解析属性
     * @author chenmingming
     *
     * @param Product $product sku
     * @param array   $attrs
     */
    protected function parseProductAttrs(Product $product, array $attrs)
    {
        foreach ($attrs as $attrId => $attrValue) {
            $key = md5($attrId . '-' . $attrValue);
            $product->addGoodsAttr($this->AttrCollection->get($key))
                ->save();
        }
    }
}