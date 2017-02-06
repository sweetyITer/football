<?php

namespace model\entity;

/**
 * AdminMasterPermission
 */
class AdminMasterPermission
{
    /**
     * @var string
     */
    private $group = 'admin';

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\AdminPermission
     */
    private $permission;

    /**
     * @var \model\entity\AdminMaster
     */
    private $master;


    /**
     * Set group
     *
     * @param string $group
     *
     * @return AdminMasterPermission
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
     * Set addTime
     *
     * @param string $addTime
     *
     * @return AdminMasterPermission
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
     * Set permission
     *
     * @param \model\entity\AdminPermission $permission
     *
     * @return AdminMasterPermission
     */
    public function setPermission(\model\entity\AdminPermission $permission = null)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get permission
     *
     * @return \model\entity\AdminPermission
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set master
     *
     * @param \model\entity\AdminMaster $master
     *
     * @return AdminMasterPermission
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
}
