<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/1
 * Time: 20:42
 */

namespace app\admin\attrset;

use app\AdminApi;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Query\Expr;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use mmapi\core\Db;
use mmapi\core\Log;
use model\entity\Attribute;
use model\entity\AttributeSet;
use model\entity\Category;
use model\entity\Goods;

class listByCategory extends AdminApi
{
    //分类id
    protected $categoryId;
    protected $goodsId;

    protected function init()
    {
        $this->addParam('categoryId')->setRequire(false)->setDefault(0);
        $this->addParam('goodsId')->setType(ApiParams::TYPE_INT)
            ->setRequire(false)
            ->setDefault(0);
    }

    public function run()
    {
        $categoryObj = null;
        if ($this->categoryId > 0) {
            $categoryObj = Category::tryInstance($this->categoryId, '分类不存在');
        }

        $attrsetRepostoryObj = AttributeSet::getRepository();
        $data                = $attrsetRepostoryObj->findBy(['cid' => [$categoryObj, null]]);

        $list         = [];
        $activeId     = 0;
        $selectedList = [];
        if ($this->goodsId) {
            /** @var Goods $goodsObj */
            $goodsObj = Goods::getInstance($this->goodsId);
            if ($goodsObj->getAttributeSet()) {
                $activeId     = $goodsObj->getAttributeSet()->getId();
                $selectedList = $goodsObj->getAttrIndexList();
            }
        }
        /** @var AttributeSet $item */
        foreach ($data as $item) {
            $attrObjList = $item->getAttributeObjList();
            $attrList    = [];
            if ($activeId == $item->getId()) {

                /** @var Attribute $attr */
                foreach ($attrObjList as $attr) {
                    $attrList[] = [
                        'id'            => $attr->getId(),
                        'attrName'      => $attr->getAttrName(),
                        'attrInputType' => $attr->getAttrInputType(),
                        'valuesArray'   => $attr->getValuesConfig($selectedList[$attr->getId()]),
                    ];
                }
            } else {
                /** @var Attribute $attr */
                foreach ($attrObjList as $attr) {
                    $attrList[] = [
                        'id'            => $attr->getId(),
                        'attrName'      => $attr->getAttrName(),
                        'attrInputType' => $attr->getAttrInputType(),
                        'valuesArray'   => $attr->getValuesConfig(),
                    ];
                }
            }

            $list[] = [
                'id'   => $item->getId(),
                'name' => $item->getName(),
                'list' => $attrList,
            ];
        }

        $this->set('data', $list);
    }

}