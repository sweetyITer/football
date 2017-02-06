<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/2
 * Time: 21:49
 */

namespace app\api\activity;

use app\AppApi;
use library\extend\Aes;
use model\entity\User;

class index extends AppApi
{
    protected function init()
    {
        $this->withoutLogin();
    }

    public function run()
    {
        $data = Aes::encrypt('hello', 'd4e5d903d4c0ee91');
        /** @var User $userObj */
        $userObj = User::getInstance(1);
        $this->set('auth', $userObj->getAuth());
        $this->set('miwen', $data);
        $this->set('encrypt', Aes::decrypt($data, 'd4e5d903d4c0ee91'));
        $this->set('data', ['ok']);
    }

}