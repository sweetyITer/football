<?php
/**
 * Created by PhpStorm.
 * User: baofan
 * Date: 2016/11/8
 * Time: 18:43
 */

namespace Sdxapp\Admin\Ajax\Master;

use Sdxapp\Admin\AdminMaster;
use Sdxapp\Api\AdminApi;
use Sdxapp\AppException;

class UpdateAjax extends AdminApi
{
    protected $id;
    protected $nick_name;
    protected $user_face;

    protected $definition = [
        'id'        => [self::TYPE_INT, self::FIELD_REQUIRE],
        'nick_name' => [self::TYPE_STRING, self::FIELD_REQUIRE],
        'user_face' => [self::TYPE_STRING, self::FIELD_REQUIRE],
    ];

    public function run()
    {
        $obj = AdminMaster::getInstance($this->id);

        $obj->update(
            [
                'nick_name'   => $this->nick_name,
                'user_face'   => $this->user_face,
                'update_time' => ['exp', 'now()'],
            ]
        );

        $this->success();
    }
}