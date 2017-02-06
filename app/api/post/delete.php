<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 14:29
 */
namespace app\api\post;

use app\AppApi;
use mmapi\core\ApiParams;
use mmapi\core\Log;
use model\entity\Post;
use mmapi\core\AppException;
use model\entity\PostComment;

class delete extends AppApi
{
    protected $post_id;

    protected function init()
    {
        $this->addParam('post_id');
    }

    /**
     * run @desc 删除帖子
     *
     * @author wangjuan
     */
    public function run()
    {
        /** @var Post $postObj */
        $postObj = Post::tryInstance($this->post_id, new AppException('帖子不合法', 'POST_INVALID'));
        if ($postObj->isDelete()) {
            throw new AppException('帖子不合法或者已经删除', 'POST_INVALID');
        }
        $postObj->setIsDelete(true)->save();
    }
}