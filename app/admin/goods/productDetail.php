<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/9
 * Time: 15:45
 */

namespace app\admin\goods;

use app\AdminApi;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use model\entity\Attribute;
use model\entity\AttributeSet;
use model\entity\Goods;
use model\entity\GoodsAttr;
use model\entity\Product;
use model\repository\GoodsRepository;

class productDetail extends AdminApi
{
    protected $goods_id;

    protected function init()
    {
        $this->addParam('goods_id')->setType(ApiParams::TYPE_INT);
    }

    public function run()
    {
        /** @var Product $product */
        $product = Product::tryInstance(1006, '222');
        $data    = [
            'ddd' => $product->getPrice(),
        ];

        $product->setPrice(2)->save();
        $this->set('data', $data);
    }

}