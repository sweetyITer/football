<?php

namespace model\entity;

/**
 * AdminMasterGroupNavigation
 */
class AdminMasterGroupNavigation
{
    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\AdminNavigation
     */
    private $nav;

    /**
     * @var \model\entity\AdminMasterGroup
     */
    private $group;


    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return AdminMasterGroupNavigation
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
     * Set nav
     *
     * @param \model\entity\AdminNavigation $nav
     *
     * @return AdminMasterGroupNavigation
     */
    public function setNav(\model\entity\AdminNavigation $nav = null)
    {
        $this->nav = $nav;

        return $this;
    }

    /**
     * Get nav
     *
     * @return \model\entity\AdminNavigation
     */
    public function getNav()
    {
        return $this->nav;
    }

    /**
     * Set group
     *
     * @param \model\entity\AdminMasterGroup $group
     *
     * @return AdminMasterGroupNavigation
     */
    public function setGroup(\model\entity\AdminMasterGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \model\entity\AdminMasterGroup
     */
    public function getGroup()
    {
        return $this->group;
    }
}
