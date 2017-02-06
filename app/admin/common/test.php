<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/10/25
 * Time: 11:55
 */

namespace app\admin\common;

use app\AdminApi;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use mmapi\api\ApiException;
use mmapi\core\ApiParams;
use mmapi\core\Cache;
use mmapi\core\Config;
use mmapi\core\Db;
use mmapi\core\Log;
use mmapi\core\QueryBuilder;
use model\adminModel;
use model\entity\AdminActionLogs;
use model\entity\AdminMaster;
use model\entity\Category;
use model\entity\Goods;
use model\entity\User;
use model\footballModel;

class test extends AdminApi
{
    protected function init()
    {
        // TODO: Implement init() method.
        $this->withoutRequireLogged();
        $this->addParam('id')->setRequire(['id必须传递', 'ID_MUST']);
    }

    public function run()
    {
        $arr1 = ['黄色', '褐色'];
        $arr2 = [32, 41];

        $result = [
            ['黄色', 32],
            ['黄色', 41],
            ['褐色', 32],
            ['褐色', 41],
        ];
        $this->set('arr1', $arr1);
    }

    public function conbination($arr, $deep = 0)
    {
        if (!$arr) {
            return [];
        }
    }

}