<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/3
 * Time: 14:49
 */
namespace app\api\address;

use app\AppApi;
use mmapi\core\AppException;
use mmapi\api\ApiException;
use model\entity\UserAddress;
use mmapi\core\ApiParams;

class setDefault extends AppApi
{
    protected $addressId;

    protected function init()
    {
        $this->addParam('addressId')->setType(ApiParams::TYPE_INT);
    }

    public function run()
    {
        /** @var UserAddress $userAddressObj */
        $userAddressObj = UserAddress::getInstance($this->addressId);
        if (is_null($userAddressObj)) {
            throw new ApiException('该地址id不存在', 'ADDRESS_NOT_EXIST');
        }
        if ($userAddressObj->getUser() != $this->user) {
            throw new AppException('用户不一致', 'USER_NOT_SAME');
        }
        $this->user->setAddressId($userAddressObj->getId())
            ->save();
    }
}