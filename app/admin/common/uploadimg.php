<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/10/25
 * Time: 17:33
 */

namespace app\admin\common;

use app\AdminApi;
use mmapi\core\Api;
use mmapi\core\ApiParams;
use mmapi\core\Config;
use mmapi\core\Image;

class uploadimg extends AdminApi
{
    protected function init()
    {
        $this->addParam('dir');
    }

    public function run()
    {

        $node = Image::provide()->uploadImg('', ['dir' => $this->dir]);

        $this
            ->set('url', $node->getUrl());
    }

}