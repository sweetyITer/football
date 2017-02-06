<?php

namespace model\entity;

use mmapi\core\AppException;
use mmapi\core\Model;
use mmapi\core\Validate;

/**
 * Attribute
 */
class Attribute extends Model
{
    //手工输入
    const ATTR_TYPE_INPUT = 'input';
    //选择输入
    const ATTR_TYPE_SELECT = 'select';
    /**
     * @var string
     */
    private $attrName;

    /**
     * @var string
     */
    private $attrInputType = self::ATTR_TYPE_INPUT;

    /**
     * @var string
     */
    private $attrValues;

    /**
     * @var integer
     */
    private $orderNum = '0';

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
     * @var array
     */
    private $valuesArray;

    private $isDelete = 0;

    public function __construct()
    {
        $this->addTime  = date('Y-m-d H:i:s');
        $this->orderNum = 99;
    }

    /**
     * Set attrName
     *
     * @param string $attrName
     *
     * @return Attribute
     */
    public function setAttrName($attrName)
    {
        $this->attrName = $attrName;

        return $this;
    }

    /**
     * Get attrName
     *
     * @return string
     */
    public function getAttrName()
    {
        return $this->attrName;
    }

    /**
     * Set attrInputType
     *
     * @param string $attrInputType
     *
     * @return Attribute
     */
    public function setAttrInputType($attrInputType)
    {
        $this->attrInputType = $attrInputType;

        return $this;
    }

    /**
     * Get attrInputType
     *
     * @return string
     */
    public function getAttrInputType()
    {
        return $this->attrInputType;
    }

    /**
     * Set attrValues
     *
     * @param string $attrValues
     *
     * @return Attribute
     * @throws AppException
     */
    public function setAttrValues($attrValues)
    {
        if (!preg_match('/^(.+,)+$/', $attrValues . ',')) {
            throw new AppException('取值范围必须以逗号分隔', 'ATTRVALUES_INVALID');
        }
        $this->attrValues = $attrValues;

        return $this;
    }

    /**
     * Get attrValues
     *
     * @return string
     */
    public function getAttrValues()
    {
        return $this->attrValues;
    }

    /**
     * Set orderNum
     *
     * @param integer $orderNum
     *
     * @return Attribute
     */
    public function setOrderNum($orderNum)
    {
        $this->orderNum = (int)$orderNum;

        return $this;
    }

    /**
     * Get orderNum
     *
     * @return integer
     */
    public function getOrderNum()
    {
        return $this->orderNum;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return Attribute
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
     * @return Attribute
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
     * @desc   setValuesArray 设置属性值数组
     * @author chenmingming
     *
     * @param array $valuesArray 属性值数组
     *
     * @return $this
     */
    public function setValuesArray(array $valuesArray)
    {
        $this->valuesArray = $valuesArray;
        $this->setAttrValues(implode(',', $valuesArray));

        return $this;
    }

    /**
     * @desc   getValuesArray
     * @author chenmingming
     * @return array
     */
    public function getValuesArray()
    {
        if (is_null($this->valuesArray)) {
            $this->valuesArray = [];
            if ($this->attrInputType == self::ATTR_TYPE_SELECT) {
                $this->valuesArray = explode(',', $this->attrValues);
            }
        }

        return $this->valuesArray;
    }

    /**
     * @desc   getValuesConfig 获取多种款式的选择情况
     * @author chenmingming
     *
     * @param array $selectedArray 选择情况 eg [123=>'黄色',45=>'蓝色']
     *
     * @return array
     */
    public function getValuesConfig($selectedArray = [])
    {
        if ($this->attrInputType == self::ATTR_TYPE_INPUT) {
            return $selectedArray;
        }
        $array = [];

        foreach ($this->getValuesArray() as $v) {
            $tmp = ['text' => $v, 'checked' => false, 'id' => 0];
            foreach ($selectedArray as $id => $value) {
                if ($v == $value) {
                    $tmp['id']      = $id;
                    $tmp['checked'] = true;
                }
            }
            $array[] = $tmp;
        }

        return $array;

    }

    /**
     * @return bool
     */
    public function isDelete()
    {
        return $this->isDelete == true;
    }

    /**
     * @param int $isDelete
     *
     * @return Attribute
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete == true;

        return $this;
    }

}

