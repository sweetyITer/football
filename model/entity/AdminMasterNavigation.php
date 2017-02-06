<?php

namespace model\entity;

/**
 * AdminMasterNavigation
 */
class AdminMasterNavigation
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
     * @var \model\entity\AdminMaster
     */
    private $master;

    /**
     * @var \model\entity\AdminNavigation
     */
    private $nav;


    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return AdminMasterNavigation
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
     * Set master
     *
     * @param \model\entity\AdminMaster $master
     *
     * @return AdminMasterNavigation
     */
    public function setMaster(\model\entity\AdminMaster $master = null)
    {
        $this->master = $master;

        return $this;
    }

    /**
     * Get master
     *
     * @return \model\entity\AdminMaster
     */
    public function getMaster()
    {
        return $this->master;
    }

    /**
     * Set nav
     *
     * @param \model\entity\AdminNavigation $nav
     *
     * @return AdminMasterNavigation
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
}
