<?php
/**
 * Created by PhpStorm.
 * User: suijing
 * Date: 2017/1/4
 * Time: 10:20
 */

namespace app\api\user;

use app\AppApi;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
//use model\entity\UerFeedback;
use model\entity\UerFeedback;
use model\entity\User;
use model\entity\UserFeedback;

class feedback extends AppApi
{
    protected $content;

    protected function init()
    {
        $this->addParam('content');
    }

    public function run()
    {
        $obj = new UserFeedback();
        $obj->setContent($this->content)
            ->setUser($this->user)
            ->setAddTime(date('Y-m-d H:i:s', time()))
            ->save();
    }

}