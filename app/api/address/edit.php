<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/3
 * Time: 14:49
 */
namespace app\api\address;

use app\AppApi;
use mmapi\api\ApiException;
use model\entity\UserAddress;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use model\entity\Region;

class edit extends AppApi
{
    protected $consignee;
    protected $phone;
    protected $province;
    protected $city;
    protected $district;
    protected $address;
    protected $addressId;

    protected function init()
    {
        $this->addParams([
            'consignee', 'province', 'city', 'district', 'phone',
        ]);
        $this->addParam('addressId')->setType(ApiParams::TYPE_INT);
        $this->addParam('address');
    }

    public function run()
    {
        /** @var UserAddress $userAddressObj */
        $userAddressObj = UserAddress::getInstance($this->addressId);
        if (is_null($userAddressObj)) {
            throw new ApiException('无效的地址id', 'INVALID_ADDRESS_ID');
        }
        if ($userAddressObj->getUser() != $this->user) {
            throw new AppException('您没有权限修改地址~', 'YOU_HAVE_NO_POWER_EDIT');
        }
        $userAddressObj
            ->setConsignee($this->consignee)
            ->setMobile($this->phone)
            ->setProvince(Region::getInstance($this->province))
            ->setCity($this->province, Region::getInstance($this->city))
            ->setDistrict($this->city, Region::getInstance($this->district))
            ->setAddress($this->address)
            ->save();
    }
}