<?php

namespace model\entity;
use model\footballModel;
use mmapi\core\Db;


/**
 * GoodsGallery
 */
class GoodsGallery extends footballModel
{

    const STYLE_200x200 = '!face';
    /**
     * @var string
     */
    private $url;

    /**
     * @var boolean
     */
    private $isDelete = false;

    /**
     * @var string
     */
    private $brief = '';

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\Goods
     */
    private $goods;

    public function __construct()
    {
        $this->addTime = date('Y-m-d H:i:s');
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return GoodsGallery
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    public function getThumb($style)
    {
        return $this->url . $style;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return GoodsGallery
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
     * Set brief
     *
     * @param string $brief
     *
     * @return GoodsGallery
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
     * Set addTime
     *
     * @param string $addTime
     *
     * @return GoodsGallery
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
     * Set goods
     *
     * @param \model\entity\Goods $goods
     *
     * @return GoodsGallery
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
     * getGoodsPicUrl @desc 获取列表里的商品图片
     * @author wangjuan
     * @param $id
     *
     * @return string
     */
    static function getGoodsPicUrl($id)
    {
       return (string)Db::create()
            ->sqlBuilder()
            ->select('url')
            ->from('mall_goods_gallery')
            ->where('is_delete')
            ->eq(0)
            ->andWhere('id')
            ->eq($id)
            ->getField('url');
    }
}

