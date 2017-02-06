<?php

namespace model\entity;
use mmapi\core\Model;

/**
 * AdminLoginLog
 */
class AdminLoginLog extends Model
{
    /**
     * @var string
     */
    private $nickName;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $ext;

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

    public function __construct()
    {
        $this->addTime = date('Y-m-d H:i:s');
    }

    /**
     * Set nickName
     *
     * @param string $nickName
     *
     * @return AdminLoginLog
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;

        return $this;
    }

    /**
     * Get nickName
     *
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return AdminLoginLog
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set ext
     *
     * @param string $ext
     *
     * @return AdminLoginLog
     */
    public function setExt($ext)
    {
        $this->ext = $ext;

        return $this;
    }

    /**
     * Get ext
     *
     * @return string
     */
    public function getExt()
    {
        return $this->ext;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return AdminLoginLog
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
     * @return AdminLoginLog
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
