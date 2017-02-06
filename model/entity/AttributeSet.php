<?php

namespace model\entity;

use mmapi\core\AppException;
use mmapi\core\Db;
use mmapi\core\Model;

/**
 * AttributeSet
 */
class AttributeSet extends Model
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\Category
     */
    private $cid;

    public function __construct()
    {
        $this->addTime = date('Y-m-d H:i:s');
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return AttributeSet
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return AttributeSet
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
     * Set cid
     *
     * @param Category | null $category
     *
     * @return AttributeSet
     * @throws AppException
     */
    public function setCategory($category)
    {
        if ($category instanceof Category || is_null($category)) {
            $this->cid = $category;
        } else {
            throw new AppException('分类对象不合法~', 'CATEGORY_INVALID');
        }

        return $this;
    }

    /**
     * Get cid
     *
     * @return \model\entity\Category
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * @desc   getAttributeList 获取某一个属性集
     * @author chenmingming
     * @return array
     */
    public function getAttributeList()
    {
        return $this->getDb()->dqlBuilder()
            ->select('a')
            ->from(Attribute::class, 'a')
            ->where('a.attributeSet=?1 and a.isDelete=0')
            ->getQuery()
            ->setParameter(1, $this->id)
            ->getArrayResult();
    }

    /**
     * @desc   getAttributeList 获取某一个属性集
     * @author chenmingming
     * @return array
     */
    public function getAttributeObjList()
    {
        return $this->getDb()->dqlBuilder()
            ->select('a')
            ->from(Attribute::class, 'a')
            ->where('a.attributeSet=?1 and a.isDelete=0')
            ->getQuery()
            ->setParameter(1, $this->id)
            ->getResult();
    }
}

