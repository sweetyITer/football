<?php

namespace model\entity;

use mmapi\core\Model;
use mmapi\core\Db;

/**
 * ZblIntro
 */
class ZblIntro extends Model
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */
    private $orderNum;

    /**
     * @var boolean
     */
    private $isOpen;

    /**
     * @var string
     */
    private $content;

    /**
     * @var boolean
     */
    private $isDelete = 0;

    /**
     * @var string
     */
    private $addTime;

    /**
     * Set title
     *
     * @param string $title
     *
     * @return ZblIntro
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return ZblIntro
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
     * Set orderNum
     *
     * @param integer $orderNum
     *
     * @return ZblIntro
     */
    public function setOrderNum($orderNum)
    {
        $this->orderNum = $orderNum;

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
     * Set isOpen
     *
     * @param boolean $isOpen
     *
     * @return ZblIntro
     */
    public function setIsOpen($isOpen)
    {
        $this->isOpen = $isOpen == true;

        return $this;
    }

    /**
     * Get isOpen
     *
     * @return boolean
     */
    public function getIsOpen()
    {
        return $this->isOpen;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return ZblIntro
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
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return ZblIntro
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete == true;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete()
    {
        return $this->isDelete;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return ZblIntro
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

}

