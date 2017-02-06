<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/3
 * Time: 14:45
 */

namespace app\api\user;

use app\AppApi;

class info extends AppApi
{
    protected function init()
    {

    }

    public function run()
    {
        $this->set('data', [
            'nick_name' => $this->user->getNickName(),
            'face_img'  => $this->user->getFaceImg(),
            'phone'     => $this->user->getPhone(),
        ]);
    }

}