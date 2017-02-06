<?php

namespace model\entity;
use mmapi\core\Log;
use model\footballModel;
use model\entity\Goods;
use mmapi\core\Db;
use model\entity\GoodsGallery;


/**
 * GoodsDetail
 */
class GoodsDetail extends footballModel
{
    /**
     * @var string
     */
    private $type = 'pc';

    /**
     * @var string
     */
    private $cover = '';

    /**
     * @var string
     */
    private $content;

    /**
     * @var \DateTime
     */
    private $updateTime = 'CURRENT_TIMESTAMP';

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


    /**
     * Set type
     *
     * @param string $type
     *
     * @return GoodsDetail
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set cover
     *
     * @param string $cover
     *
     * @return GoodsDetail
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
     * Set content
     *
     * @param string $content
     *
     * @return GoodsDetail
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set updateTime
     *
     * @param \DateTime $updateTime
     *
     * @return GoodsDetail
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
     * @return GoodsDetail
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
     * @return GoodsDetail
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
     *
     * getCoverImgs @desc
     * @author wangjuan
     * @return array
     */
    public function getCoverImgs()
    {
        $coverImg = [];
        $arr = explode(',', $this->cover);
        if(is_array($arr)){
            foreach ($arr as $v){
                /** @var GoodsGallery  $galleryObj */
                $galleryObj = GoodsGallery::getInstance($v);
                if(!is_null($galleryObj) && $galleryObj->getUrl()){
                    array_push($coverImg, $galleryObj->getUrl());
                }else{
                    continue;
                }
            }
        }
        return  $coverImg;
    }

    /**
     * getContentImgs @desc
     * @author wangjuan
     * @return array
     */
    public function getContentImgs()
    {
        $contentImgs = [];
        $contentArray = json_decode($this->getContent(),true);
        if($contentArray["imgs"]){
            foreach($contentArray["imgs"] as $v){
                /** @var GoodsGallery  $galleryObj */
                $galleryObj = GoodsGallery::getInstance($v);
                if(!is_null($galleryObj) && $galleryObj->getUrl()){
                    array_push($contentImgs, $galleryObj->getUrl());
                }else{
                    continue;
                }
            }
        }
        return $contentImgs;
    }

    static public function getIdByGoodsId($goodsId)
    {
        return (int)Db::create()
            ->sqlBuilder()
            ->select('id')
            ->from('mall_goods_detail')
            ->where('goods_id')
            ->eq($goodsId)
            ->getField('id');
    }
}

