<?php

namespace model\entity;
use app\api\Login\login;
use model\footballModel;
use mmapi\core\Log;

/**
 * OrderAddress
 */
class OrderAddress extends footballModel
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
     * @var string
     */
    private $addTime;

    /**
     * @var \DateTime
     */
    private $updateTime = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\Order
     */
    private $order;

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
     * @var \model\entity\Region
     */
    private $province;


    
    /**
     * Set addressName
     *
     * @param string $addressName
     *
     * @return OrderAddress
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
     * @return OrderAddress
     */
    public function setConsignee($consignee)
    {
        $this->consignee = $consignee;

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
     * @return OrderAddress
     */
    public function setSex($sex)
    {
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
     * @return OrderAddress
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
     * @return OrderAddress
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
     * @return OrderAddress
     */
    public function setZipcode($zipcode)
    {
        Log::alert("3635");
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
     * @return OrderAddress
     */
    public function setMobile($mobile)
    {
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
     * @return OrderAddress
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
     * Set addTime
     *
     * @param string $addTime
     *
     * @return OrderAddress
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
     * @return OrderAddress
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set order
     *
     * @param \model\entity\Order $order
     *
     * @return OrderAddress
     */
    public function setOrder(\model\entity\Order $order = null)
    {
        Log::alert("360");

        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \model\entity\Order
     */
    public function getOrder()
    { Log::alert("361");
        return $this->order;
    }

    /**
     * Set city
     *
     * @param \model\entity\Region $city
     *
     * @return OrderAddress
     */
    public function setCity(\model\entity\Region $city = null)
    {
        Log::alert("362");
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
     *
     * @return OrderAddress
     */
    public function setDistrict(\model\entity\Region $district = null)
    {
        Log::alert("363");
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
     * @return OrderAddress
     */
    public function setCountry(\model\entity\Region $country = null)
    {
        Log::alert("364");
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
     * Set province
     *
     * @param \model\entity\Region $province
     *
     * @return OrderAddress
     */
    public function setProvince(\model\entity\Region $province = null)
    {
        Log::alert("365");
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
}

