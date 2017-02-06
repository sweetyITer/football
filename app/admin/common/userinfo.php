<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/7/7
 * Time: 23:13
 */

namespace app\admin\common;

use app\AdminApi;
use mmapi\api\ApiException;
use mmapi\core\AppException;

class userinfo extends AdminApi
{
    protected function init()
    {

    }

    public function run()
    {
        $this->set('data',
            [
                'id'        => $this->adminMaster->getId(),
                'nick_name' => $this->adminMaster->getNickName(),
                'user_face' => $this->adminMaster->getUserFace(),
            ]
        );
    }
}