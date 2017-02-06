<?php

namespace model\entity;

use library\extend\Aes;
use mmapi\core\Config;
use mmapi\core\Db;
use mmapi\core\Model;

/**
 * AdminMaster
 */
class AdminMaster extends Model
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone = '';

    /**
     * @var string
     */
    private $userFace = '';

    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $nickName;

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var string
     */
    private $salt = '';

    /**
     * @var string
     */
    private $lastLoginTime;

    /**
     * @var string
     */
    private $lastLoginIp = '';

    /**
     * @var string
     */
    private $lastIpAddr = '';

    /**
     * @var string
     */
    private $guid = '';

    /**
     * @var string
     */
    private $from = '';

    /**
     * @var boolean
     */
    private $isLock = '1';

    /**
     * @var \DateTime
     */
    private $updateTime = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\AdminMasterGroup
     */
    private $group;

    /**
     * Set email
     *
     * @param string $email
     *
     * @return AdminMaster
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return AdminMaster
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set userFace
     *
     * @param string $userFace
     *
     * @return AdminMaster
     */
    public function setUserFace($userFace)
    {
        $this->userFace = $userFace;

        return $this;
    }

    /**
     * Get userFace
     *
     * @return string
     */
    public function getUserFace()
    {
        return $this->userFace;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return AdminMaster
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set nickName
     *
     * @param string $nickName
     *
     * @return AdminMaster
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
     * Set password
     *
     * @param string $password
     *
     * @return AdminMaster
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return AdminMaster
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set lastLoginTime
     *
     * @param string $lastLoginTime
     *
     * @return AdminMaster
     */
    public function setLastLoginTime($lastLoginTime = '')
    {
        if ($lastLoginTime == '') {
            $lastLoginTime = date('Y-m-d H:i:s');
        }
        $this->lastLoginTime = $lastLoginTime;

        return $this;
    }

    /**
     * Get lastLoginTime
     *
     * @return string
     */
    public function getLastLoginTime()
    {
        return $this->lastLoginTime;
    }

    /**
     * Set lastLoginIp
     *
     * @param string $lastLoginIp
     *
     * @return AdminMaster
     */
    public function setLastLoginIp($lastLoginIp)
    {
        $this->lastLoginIp = $lastLoginIp;

        return $this;
    }

    /**
     * Get lastLoginIp
     *
     * @return string
     */
    public function getLastLoginIp()
    {
        return $this->lastLoginIp;
    }

    /**
     * Set lastIpAddr
     *
     * @param string $lastIpAddr
     *
     * @return AdminMaster
     */
    public function setLastIpAddr($lastIpAddr)
    {
        $this->lastIpAddr = $lastIpAddr;

        return $this;
    }

    /**
     * Get lastIpAddr
     *
     * @return string
     */
    public function getLastIpAddr()
    {
        return $this->lastIpAddr;
    }

    /**
     * Set guid
     *
     * @param string $guid
     *
     * @return AdminMaster
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;

        return $this;
    }

    /**
     * Get guid
     *
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * Set from
     *
     * @param string $from
     *
     * @return AdminMaster
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set isLock
     *
     * @return AdminMaster
     */
    public function Locked()
    {
        $this->isLock = true;

        return $this;
    }

    /**
     * @desc   unLocked
     * @author chenmingming
     * @return $this
     */
    public function unLocked()
    {
        $this->isLock = false;

        return $this;
    }

    /**
     * Get isLock
     *
     * @return boolean
     */
    public function isLock()
    {
        return $this->isLock == 1;
    }

    /**
     * Set updateTime
     *
     * @param \DateTime $updateTime
     *
     * @return AdminMaster
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return \DateTime
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return AdminMaster
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
     * Set group
     *
     * @param \model\entity\AdminMasterGroup $group
     *
     * @return AdminMaster
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

    /**
     * checkPasswd 检测密码是否正确
     *
     * @author chenmingming
     *
     * @param string $passwd 密码
     *
     * @return bool
     */
    public function verifyPassword($passwd)
    {
        return $this->password == self::encodePasswd($passwd, $this->salt);
    }

    /**
     * encodePasswd 加密密码
     *
     * @author chenmingming
     *
     * @param string $passwd 待加密密码
     * @param string $salt   盐值
     *
     * @return string
     */
    static private function encodePasswd($passwd, $salt)
    {
        return md5(md5($passwd) . md5($salt));
    }

    /**
     * @desc   regLogin
     * @author chenmingming
     *
     * @param string $from 来源
     */
    public function regLogin($from = 'password')
    {
        $lifetime = time() + 86400 * 3;
        $guid     = md5(uniqid());
        $auth     = implode("\t", [$this->id, $guid, $lifetime]);
        $P00001   = Aes::encrypt($auth, Config::get('auth.key'));

        $this->setLastLoginIp($_SERVER['REMOTE_ADDR'])
            ->setGuid($guid)
            ->setLastLoginTime()
            ->save();

        $loginLog = new AdminLoginLog();
        $loginLog->setMaster($this)
            ->setNickName($this->nickName)
            ->setExt(
                json_encode(['from' => $from,])
            )
            ->setIp($this->lastLoginIp)
            ->save();
        setcookie(Config::get('auth.name'), $P00001, $lifetime, '/', Config::get('auth.domain'));
    }

}

