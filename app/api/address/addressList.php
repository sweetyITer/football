<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/3
 * Time: 14:49
 */
namespace app\api\address;

use app\AppApi;
use model\entity\UserAddress;

class addressList extends AppApi
{
    protected function init()
    {
    }

    public function run()
    {
        $userAddress = UserAddress::getRepository()->findBy(['user' => $this->user, 'isDelete' => 0]);
        $data        = [];
        /** @var UserAddress $item */
        foreach ($userAddress as $item) {
            $data[] = [
                'province'     => $item->getProvince()->getRegionId(),
                'provinceName' => $item->getProvince()->getRegionName(),
                'city'         => $item->getCity()->getRegionId(),
                'cityName'     => $item->getCity()->getRegionName(),
                'district'     => $item->getDistrict()->getRegionId(),
                'districtName' => $item->getDistrict()->getRegionName(),
                'consignee'    => $item->getConsignee(),
                'phone'        => $item->getMobile(),
                'address'      => $item->getAddress(),
                'addressId'    => $item->getId(),
            ];
        }

        $this->set('data', $data);
    }
}