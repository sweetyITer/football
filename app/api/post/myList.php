<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 14:34
 */
namespace app\api\post;

use app\AppApi;
use model\entity\Post;
use mmapi\core\ApiParams;

class myList extends AppApi
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
        $this->page || $this->page = 1;
        $this->size || $this->size = 3;
      
        $this->set('data', [
            'list' => Post::getMyList($this->user, $this->page, $this->size)
        ]);

    }
}
