<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/11
 * Time: 10:59
 */
namespace app\api\post;

use app\AppApi;
use model\entity\Post;
use mmapi\core\ApiParams;

class myMoreList extends AppApi
{
    protected $page;
    protected $size;

    protected function init()
    {
        $this->addParam('page')->setRequire(ApiParams::TYPE_INT);
        $this->addParam('size')->setRequire(ApiParams::TYPE_INT);
    }

    /**
     * run @desc 我的帖子列表
     *
     * @author wangjuan
     */
    public function run()
    {
        $this->size || $this->size = 3;
        $this->page || $this->page = 2;

        $this->set('data', [
            'list' => Post::getMyList($this->user, $this->page, $this->size)
        ]);

    }
}

