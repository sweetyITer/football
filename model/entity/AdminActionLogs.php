<?php

namespace model\entity;

/**
 * AdminActionLogs
 */
class AdminActionLogs
{
    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $nickName;

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


    /**
     * Set action
     *
     * @param string $action
     *
     * @return AdminActionLogs
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return AdminActionLogs
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set nickName
     *
     * @param string $nickName
     *
     * @return AdminActionLogs
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
     * Set ext
     *
     * @param string $ext
     *
     * @return AdminActionLogs
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
     * @return AdminActionLogs
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
     * @return AdminActionLogs
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
     * @var integer
     */
    private $masterId;


    /**
     * Set masterId
     *
     * @param integer $masterId
     *
     * @return AdminActionLogs
     */
    public function setMasterId($masterId)
    {
        $this->masterId = $masterId;

        return $this;
    }

    /**
     * Get masterId
     *
     * @return integer
     */
    public function getMasterId()
    {
        return $this->masterId;
    }
}
