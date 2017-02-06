<?php

namespace model\entity;
use mmapi\core\Model;

/**
 * Quan
 */
class Quan extends Model
{
    /**
     * @var string
     */
    private $group = 'north';

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var integer
     */
    private $followCount = 0;

    /**
     * @var integer
     */
    private $postCount = 0;

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;

    public function __construct()
    {
        $this->addTime = date('Y-m-d H:i:s');
    }

    /**
     * Set group
     *
     * @param string $group
     *
     * @return Quan
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Quan
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
     * Set icon
     *
     * @param string $icon
     *
     * @return Quan
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set followCount
     *
     * @param integer $followCount
     *
     * @return Quan
     */
    public function setFollowCount($followCount)
    {
        $this->followCount = $followCount;

        return $this;
    }

    /**
     * Get followCount
     *
     * @return integer
     */
    public function getFollowCount()
    {
        return $this->followCount;
    }

    /**
     * Set postCount
     *
     * @param integer $postCount
     *
     * @return Quan
     */
    public function setPostCount($postCount)
    {
        $this->postCount = $postCount;

        return $this;
    }

    /**
     * Get postCount
     *
     * @return integer
     */
    public function getPostCount()
    {
        return $this->postCount;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return Quan
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

