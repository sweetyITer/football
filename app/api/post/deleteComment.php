<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/11
 * Time: 15:49
 */
namespace app\api\post;

use app\AppApi;
use mmapi\api\ApiException;
use model\entity\PostComment;
use model\entity\Post;
use mmapi\core\AppException;
use mmapi\core\Db;

class deleteComment extends AppApi
{
    protected $comment_id;

    protected function init()
    {
        $this->addParam('comment_id');
    }

    /**
     * run @desc 删除帖子
     *
     * @author wangjuan
     */
    public function run()
    {
        /** @var PostComment $postCommentObj */
        $postCommentObj = PostComment::tryInstance($this->comment_id, ['评论无效', 'COMMENT_ID_INVALID'] );
        if ($postCommentObj->isDelete()) {
        //    PostComment::changePostCommentNum($postCommentObj)
            throw new ApiException('帖子不合法或者已经删除', 'POST_INVALID');
        }
        $postCommentObj->setIsDelete(true)->save();
        $postObj = $postCommentObj->getPost();
        $postObj->setCommentCount((int)$postObj->getCommentCount() - 1)
            ->save();
    }
}