<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/6
 * Time: 10:36
 */
namespace app\api\Post;

use app\AppApi;
use mmapi\core\ApiParams;
use model\entity\PostComment;
use mmapi\core\AppException;

class CommentUp extends AppApi
{
    protected $comment_id;

    protected function init()
    {
        $this->addParam('comment_id')->setType(ApiParams::TYPE_INT);
    }

    /**
     * run @desc 给帖子评论点赞/取消赞
     *
     * @author wangjuan
     */
    public function run()
    {
        /** @var PostComment $postCommentObj */
        $postCommentObj = PostComment::tryInstance($this->comment_id, new AppException('评论不合法~', 'COMMENT_ID_INVALID'));
        if (!$postCommentObj->isCommentUp($this->user)) {
            $postCommentObj->setCommentUp($this->user);
        }else{
            throw new AppException('您已经点赞~', 'ALREADY_UP');
        }
    }
}