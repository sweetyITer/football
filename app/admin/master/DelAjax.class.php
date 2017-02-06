<?php
/**
 * Created by PhpStorm.
 * User: baofan
 * Date: 2016/11/7
 * Time: 16:04
 */

namespace Sdxapp\Admin\Ajax\Master;

use Sdxapp\Admin\AdminMaster;
use Sdxapp\Api\AdminApi;

class DelAjax extends AdminApi
{
    protected $id;
    protected $definition = [
        'id' => [self::TYPE_INT, self::FIELD_REQUIRE],
    ];

    public function run()
    {
        $obj = AdminMaster::getInstance($this->id);
        $obj->delMaster();
        $this->success();
    }
}