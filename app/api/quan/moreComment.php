<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/10
 * Time: 15:55
 */
namespace app\api\quan;

use app\AppApi;
use mmapi\core\ApiParams;
use model\entity\Post;
use model\entity\PostComment;
use mmapi\core\AppException;

class moreComment extends AppApi
{
    protected $post_id;
    protected $page;
    protected $size;

    protected function init()
    {
        $this->addParam('post_id');
        $this->addParam('page')->setRequire(ApiParams::TYPE_INT);
        $this->addParam('size')->setRequire(ApiParams::TYPE_INT);
        $this->get('auth')->setRequire(false);
    }

    /**
     * run @desc 圈子详情
     *
     * @author wangjuan
     */
    public function run()
    {
        $this->page || $this->page = 2;
        $this->size || $this->size = 3;
        $postObj = Post::tryInstance($this->post_id, new AppException('圈子不合法', 'QUAN_INVALID'));
        $this->set('data',  PostComment::getComment($postObj->getId(), $this->page, $this->size));
    }
}


