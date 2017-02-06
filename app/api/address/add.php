<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/3
 * Time: 14:49
 */
namespace app\api\address;

use app\AppApi;
use model\entity\Region;
use model\entity\UserAddress;
use mmapi\core\ApiParams;
use mmapi\core\AppException;

class add extends AppApi
{
    protected $consignee;
    protected $phone;
    protected $province;
    protected $city;
    protected $district;
    protected $address;

    protected function init()
    {
        $this->addParams([
            'consignee', 'province', 'city', 'district', 'phone',
        ]);
        $this->addParam('address');
    }

    public function run()
    {
        $userAddressObj = new UserAddress();
        $userAddressObj
            ->setUser($this->user)
            ->setConsignee($this->consignee)
            ->setMobile($this->phone)
            ->setProvince(Region::getInstance($this->province))
            ->setCity($this->province, Region::getInstance($this->city))
            ->setDistrict($this->city, Region::getInstance($this->district))
            ->setAddress($this->address)
            ->save();
    }
}