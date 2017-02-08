<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/2
 * Time: 20:22
 */

namespace app\api\common;

use app\AppApi;
use mmapi\api\DenyResubmitApi;
use mmapi\core\Api;
use mmapi\core\Config;
use mmapi\core\Db;
use mmapi\tool\ModelXmlBuilder;
use model\entity\Post;
use model\entity\Quan;
use model\entity\User;

class test extends DenyResubmitApi
{
    protected function init()
    {
    }

    public function run()
    {
        $obj = new ModelXmlBuilder();
        $obj->setDb(Db::create())->setNamespace('model\entity');
        $obj
            ->setTableName('zbl_intro_module')
            ->builder(VPATH . '/model/xml/');
    }

}