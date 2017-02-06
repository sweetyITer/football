<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/19
 * Time: 20:18
 */

namespace app\admin\attrset;

use app\AdminApi;
use mmapi\core\Api;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use mmapi\core\Db;
use model\entity\Attribute;
use model\entity\AttributeSet;
use model\entity\Category;

class add extends AdminApi
{
    protected $id;
    protected $categoryId;
    protected $list;
    protected $name;

    protected function init()
    {
        $this->addParam('id')->setRequire(false);
        $this->addParam('categoryId')->setType(ApiParams::TYPE_INT)->setRequire(false)->setDefault(0);
        $this->addParam('list')->setType(ApiParams::TYPE_ARRAY);
        $this->addParam('name');
        $this->denyResubmit();
    }

    public function run()
    {
        $categoryObj = null;
        if ($this->categoryId) {
            $categoryObj = Category::getInstance($this->categoryId);
            if (is_null($categoryObj))
                throw new AppException('category_id 不合法~', 'CATEGORY_ID_INVALID');
        }
        if ($this->id) {
            $attrsetObj = AttributeSet::getInstance($this->id);
            if (is_null($attrsetObj))
                throw new AppException('属性集id不存在', 'attribute_set_not_exist');
        } else {
            $attrsetObj = new AttributeSet();
        }
        $attrsetObj->setCategory($categoryObj);
        $attrsetObj->setName($this->name);
        $attrsetObj->save();
        $this->saveAttribute($attrsetObj);

        $this->set('data.id', $attrsetObj->getId());
    }

    private function saveAttribute(AttributeSet $attributeSetObj)
    {
        $objList = $attributeSetObj->getAttributeObjList();

        $oldIdList = [];
        foreach ($this->list as $item) {
            if ($item['id']) {
                $oldIdList[] = $item['id'];
            }
        }

        /** @var Attribute $obj */
        foreach ($objList as $obj) {
            $obj->setIsDelete(!in_array($obj->getId(), $oldIdList))
                ->save();
        }

        foreach ($this->list as $item) {
            if ($item['id']) {
                $attrObj = Attribute::getInstance($item['id']);
            } else {
                $attrObj = new Attribute();
            }

            $attrObj->setAttributeSet($attributeSetObj)
                ->setAttrInputType($item['attrInputType'])
                ->setAttrName($item['attrName'])
                ->setOrderNum($item['orderNum']);

            if ($attrObj->getAttrInputType() == $attrObj::ATTR_TYPE_SELECT) {
                $attrObj->setAttrValues($item['attrValues']);
            } else {
                $attrObj->setAttrValues('');
            }
            $attrObj->save();
        }
    }

}