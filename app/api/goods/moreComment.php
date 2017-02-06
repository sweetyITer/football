<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/18
 * Time: 11:13
 */
namespace app\api\goods;

use app\admin\goods\productDetail;
use app\AppApi;
use mmapi\core\ApiParams;
use mmapi\core\Db;
use mmapi\core\Log;
use model\entity\NewsComment;
use model\entity\MallGoodsComment;
use model\entity\Goods;
use model\entity\GoodsDetail;
use model\entity\Attribute;

class moreComment extends AppApi
{
    protected $page;
    protected $size;
    protected $goods_id;

    protected function init()
    {
        $this->addParams(['page', 'size', 'goods_id']);
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        $this->page || $this->page = 2;
        $this->size || $this->size = 5;
        /** @var Goods $goodsObj */
        $goodsObj = Goods::tryInstance($this->goods_id, ['商品无效', 'GOODS_UNVALID']);
        $list     = MallGoodsComment::getList($goodsObj, $this->page, $this->size, $this->user ? $this->user : null);
        $this->set('data', $list);
    }

}