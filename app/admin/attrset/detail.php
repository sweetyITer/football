<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/21
 * Time: 14:10
 */

namespace app\admin\attrset;

use app\AdminApi;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use mmapi\core\Db;
use model\entity\AttributeSet;

class detail extends AdminApi
{
    protected function init()
    {
        $this->addParam('id')->setType(ApiParams::TYPE_INT);
    }

    public function run()
    {
        /** @var AttributeSet $attributeSetObj */
        $attributeSetObj = AttributeSet::getInstance($this->id);
        if (is_null($attributeSetObj)) {
            throw new AppException('该属性集不存在', 'ATTRIBUTE_SET_NOT_EXIST');
        }
        $this->set(
            'data',
            [
                'id'           => $attributeSetObj->getId(),
                'name'         => $attributeSetObj->getName(),
                'categoryId'   =>
                    $attributeSetObj->getCid() ? $attributeSetObj->getCid()->getId() : '',
                'categoryName' => $attributeSetObj->getCid() ? $attributeSetObj->getCid()->getName() : '',
                'list'         => $attributeSetObj->getAttributeList(),
            ]
        );

    }

}