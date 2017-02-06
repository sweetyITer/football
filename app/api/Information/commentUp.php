<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/16
 * Time: 15:43
 */
namespace app\api\Information;

use app\AppApi;
use mmapi\api\ApiException;
use model\entity\NewsComment;

class commentUp extends AppApi
{
    protected $comment_id;

    protected function init()
    {
        $this->addParam('comment_id');
    }

    public function run()
    {
        /** @var NewsComment $newsCommentObj */
        $newsCommentObj = NewsComment::tryInstance($this->comment_id, ['评论无效', 'COMMENT_UNVALID']);
        if($newsCommentObj->isDelete()){
            throw new ApiException('评论已经删除','COMMENT_ALREADY_DELETED');
        }
        if(!$newsCommentObj->isCommentUp($this->user)){
            $newsCommentObj->setCommentUp($this->user);
        }else{
            throw new ApiException('已经点赞', 'COMMENT_ALREADY_UP');
        }

    }
}