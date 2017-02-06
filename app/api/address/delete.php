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
use mmapi\core\ApiParams;
use mmapi\core\AppException;

class delete extends AppApi
{
    protected $addressId;

    protected function init()
    {
        $this->addParam('addressId')->setType(ApiParams::TYPE_INT);
    }

    public function run()
    {
        $userAddressObj = UserAddress::getInstance($this->addressId);
        if ($userAddressObj->getUser() != $this->user) {
            throw new AppException('您没有权限删除地址~', 'YOU_HAVE_NO_POWER');
        }
        $userAddressObj->remove();
    }
}