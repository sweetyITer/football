<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/19
 * Time: 15:55
 */
namespace app\api\login;

use app\AppApi;
use model\entity\User;

class loginOut extends AppApi
{

    protected function init()
    {

    }

    public function run()
    {
        User::loginOut();
    }

}