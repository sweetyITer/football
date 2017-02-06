<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/22
 * Time: 13:53
 */
namespace app\api\user;

use app\AppApi;
use model\entity\Video;
use model\entity\News;
use model\entity\Post;

class myCollect extends AppApi
{
    protected $type;
    protected $page;
    protected $size;

    protected function init()
    {
        $this->addParams(['type', 'page', 'size']);
    }

    /**
     * run @desc
     *
     * @author wangjuan
     */
    public function run()
    {
        $list = [];
        $this->page || $this->page = 1;
        switch ($this->type) {
            case "video":
                $this->size || $this->size = Video::COLLECT_SIZE;
                $list = Video::getCollectList($this->user, $this->page, $this->size);
                break;
            case 'news':
                $this->size || $this->size = News::COLLECT_SIZE;
                $list = News::getCollectList($this->user, $this->page, $this->size);
                break;
            case 'post':
                $this->size || $this->size = Post::COLLECT_SIZE;
                $list = Post::getCollectList($this->user, $this->page, $this->size);
                break;
        }
        $this->set('data', $list);
    }
}
