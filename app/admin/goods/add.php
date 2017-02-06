<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/18
 * Time: 13:57
 */

namespace app\admin\goods;

use app\AdminApi;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use mmapi\core\Db;
use mmapi\core\Log;
use model\entity\Brand;
use model\entity\Category;
use model\entity\Goods;
use model\entity\GoodsGallery;

class add extends AdminApi
{
    protected function init()
    {
        $this->addParam('id')->setRequire(false);
        $this->addParam('goodsSn')->setRequire(false)->setDefault(Goods::createSn());
        $this->addParam('orginalPrice')->setType(ApiParams::TYPE_FLOAT);
        $this->addParam('currentPrice')->setType(ApiParams::TYPE_FLOAT);
        $this->addParam('cover')->setRequire(false);
        $this->addParam('keywords')->setRequire(false);
        $this->addParam('note')->setRequire(false);
        $this->addParam('isBest')->setRequire(ApiParams::TYPE_STRING)->setRequire(false)->setDefault(false);
        $this->addParam('title');

        $this->addParam('subTitle');
        $this->addParam('brief');
        $this->addParam('brand');
        $this->addParam('category');
        $this->setDenyResubmitKey(['id'], 'addGoods');
    }

    public function run()
    {
        if ($this->id) {
            //更新商品信息
            /** @var Goods $goodsObj */
            $goodsObj = Goods::getInstance($this->id);
            if (is_null($goodsObj)) {
                throw new AppException('该商品不存在', 'GOODS_NOT_EXISET');
            }
            if ($goodsObj->isDelete()) {
                throw new AppException('该商品已经删除,不能修改', 'GOODS_IS_DELETED');
            }
        } else {
            //添加新商品信息
            $goodsObj = new Goods();
        }

        /** @var Category $catetoryObj */
        $catetoryObj = Category::getInstance($this->category);
        $goodsObj->setCid($catetoryObj);

        /** @var Brand $brandObj */
        $brandObj = Brand::getInstance($this->brand);

        $goodsObj
            ->setBrand($brandObj)
            ->setGoodsSn($this->goodsSn)
            ->setOriginalPrice($this->orginalPrice)
            ->setCurrentPrice($this->currentPrice)
            ->setTitle($this->title)
            ->setSubTitle($this->subTitle)
            ->setKeywords($this->keywords)
            ->setBrief($this->brief)
            ->setIsBest($this->isBest)
            ->setNote($this->note);

        $goodsObj->getId() || $goodsObj->save();

        $this->checkCover($goodsObj);
        $goodsObj->save();
        $this->set('data.id', $goodsObj->getId());
    }

    private function checkCover(Goods $goodsObj)
    {
        if ($this->cover) {
            if (is_null($goodsObj->getCoverImg()) || $goodsObj->getCoverImg()->getUrl() != $this->cover) {
                $goodsImgObj = new GoodsGallery();
                $goodsImgObj
                    ->setUrl($this->cover)
                    ->setBrief('封面图片')
                    ->setGoods($goodsObj)
                    ->save();
                $goodsObj->setCoverImg($goodsImgObj);
            }
        }
    }
}