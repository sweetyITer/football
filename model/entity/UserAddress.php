<?php

namespace model\entity;

use model\footballModel;
use mmapi\core\AppException;

/**
 * UserAddress
 */
class UserAddress extends footballModel
{
    /**
     * @var string
     */
    private $addressName = '';

    /**
     * @var string
     */
    private $consignee;

    /**
     * @var string
     */
    private $sex = 'unkonw';

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $zipcode = '';

    /**
     * @var string
     */
    private $mobile = '';

    /**
     * @var string
     */
    private $signBuilding = '';

    /**
     * @var boolean
     */
    private $isDelete = '0';

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var string
     */
    private $updateTime;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\Region
     */
    private $city;

    /**
     * @var \model\entity\Region
     */
    private $district;

    /**
     * @var \model\entity\Region
     */
    private $country;

    /**
     * @var \model\entity\User
     */
    private $user;

    /**
     * @var \model\entity\Region
     */
    private $province;

    public function __construct()
    {
        $this->addTime = date('Y-m-d H:i:s');
    }

    /**
     * Set addressName
     *
     * @param string $addressName
     *
     * @return UserAddress
     */
    public function setAddressName($addressName)
    {
        $this->addressName = $addressName;

        return $this;
    }

    /**
     * Get addressName
     *
     * @return string
     */
    public function getAddressName()
    {
        return $this->addressName;
    }

    /**
     * Set consignee
     *
     * @param string $consignee
     *
     * @return UserAddress
     */
    public function setConsignee($consignee)
    {
        if (!is_null($consignee)) {
            $this->consignee = $consignee;
        }

        return $this;
    }

    /**
     * Get consignee
     *
     * @return string
     */
    public function getConsignee()
    {
        return $this->consignee;
    }

    /**
     * Set sex
     *
     * @param string $sex
     *
     * @return UserAddress
     */
    public function setSex($sex)
    {
        if (in_array($sex, [0, 1, 2]))
            $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return UserAddress
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
     * Set address
     *
     * @param string $address
     *
     * @return UserAddress
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     *
     * @return UserAddress
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return UserAddress
     */
    public function setMobile($mobile)
    {
        if (!$this->isPhone($mobile)) {
            throw new AppException('手机号码不合法~', 'PHONE_NOT_LEGAL');
        }
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set signBuilding
     *
     * @param string $signBuilding
     *
     * @return UserAddress
     */
    public function setSignBuilding($signBuilding)
    {
        $this->signBuilding = $signBuilding;

        return $this;
    }

    /**
     * Get signBuilding
     *
     * @return string
     */
    public function getSignBuilding()
    {
        return $this->signBuilding;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return UserAddress
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
    public function isDelete()
    {
        return $this->isDelete;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return UserAddress
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
     * Set updateTime
     *
     * @param \DateTime $updateTime
     *
     * @return UserAddress
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
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
     * Set city
     *
     * @param \model\entity\Region $city
     * @param                      $province
     *
     * @return UserAddress
     */
    public function setCity($province, \model\entity\Region $city = null)
    {
        /** @var Region $regionObj */
        $regionObj = Region::getInstance($city);
        if (is_null($regionObj)) {
            throw new AppException('该地区id不存在', 'REGION_ID_NOT_EXIST');
        }
        if ($regionObj->getRegionType() != 2 || $regionObj->getParentId() != $province) {
            throw new AppException('市不合法', 'CITY_NOT_LEGAL');
        }
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \model\entity\Region
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set district
     *
     * @param \model\entity\Region $district
     * @param                      $city
     *
     * @return UserAddress
     */
    public function setDistrict($city, \model\entity\Region $district = null)
    {
        /** @var Region $regionObj */
        $regionObj = Region::getInstance($district);
        if (is_null($regionObj)) {
            throw new AppException('该地区id不存在', 'REGION_ID_NOT_EXIST');
        }
        if ($regionObj->getRegionType() != 3 || $regionObj->getParentId() != $city) {
            throw new AppException('区不合法', 'DISTRICT_NOT_LEGAL');
        }
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return \model\entity\Region
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Set country
     *
     * @param \model\entity\Region $country
     *
     * @return UserAddress
     */
    public function setCountry(\model\entity\Region $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \model\entity\Region
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return UserAddress
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \model\entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set province
     *
     * @param \model\entity\Region $province
     *
     * @return UserAddress
     */
    public function setProvince(\model\entity\Region $province = null)
    {
        /** @var Region $regionObj */
        $regionObj = Region::getInstance($province);
        if (is_null($regionObj)) {
            throw new AppException('该地区id不存在', 'REGION_ID_NOT_EXIST');
        }
        if ($regionObj->getRegionType() != 1) {
            throw new AppException('省份不合法', 'PROVINCE_NOT_LEGAL');
        }
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \model\entity\Region
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     *  isPhone
     *
     * @return bool
     */
    public function isPhone($mobile)
    {
        return preg_match('/^1[0-9]{10}$/', $mobile);
    }
}

