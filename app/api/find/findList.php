<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/23
 * Time: 15:35
 */
namespace app\api\find;

use app\AppApi;
use model\entity\Post;

class findList extends AppApi
{
    protected $page;
    protected $size;

    protected function init()
    {
        $this->addParams(['page', 'size']);
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        $this->page || $this->page = 1;
        $this->size || $this->size = 3;
        $data = [
            "activeHeadpics" => Post::getTodayActiveHeadPics(null),
            "postList"       => Post::getQuanList($this->user, null, $this->page, $this->size),
        ];
        $this->set('data', $data);
    }
}