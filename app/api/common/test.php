<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/2
 * Time: 20:22
 */

namespace app\api\common;

use app\AppApi;
use mmapi\core\Api;
use mmapi\core\Config;
use mmapi\core\Db;
use mmapi\tool\ModelXmlBuilder;
use model\entity\Post;
use model\entity\Quan;
use model\entity\User;

class test extends AppApi
{
    protected function init()
    {
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        $this->set('dsdsd', 222);
    }

}