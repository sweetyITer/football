<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/6
 * Time: 10:35
 */
namespace app\api\Post;

use app\AppApi;
use mmapi\core\ApiParams;
use mmapi\core\Db;
use model\entity\PostComment;
use model\entity\User;
use model\entity\Post;
use mmapi\core\AppException;

class addComment extends AppApi
{
    protected $post_id;
    protected $content;

    protected function init()
    {
        $this->addParams(['post_id', 'content']);
    }

    /**
     * run @desc 添加评论
     *
     * @author wangjuan
     */
    public function run()
    {
        /** @var Post $postObj */
        $postObj = Post::tryInstance($this->post_id, new AppException('帖子不合法', 'POST_INVALID'));
        if ($postObj->isDelete()) {
            throw new AppException('帖子已经删除', 'POST_INVALID');
        }
        $postCommentObj = new PostComment();
        $postCommentObj
            ->setUser($this->user)
            ->setPost($postObj)
            ->setContent($this->content)
            ->save();
        if ($postCommentObj->getId() > 0) {
            $postObj->setCommentCount((int)$postObj->getCommentCount() + 1)
                ->save();
        }
        $this->set('comment_id', $postCommentObj->getId());
    }
}