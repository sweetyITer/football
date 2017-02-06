<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/18
 * Time: 10:57
 */
namespace app\api\Goods;

use app\AppApi;
use mmapi\api\ApiException;
use mmapi\core\ApiParams;
use mmapi\core\Db;
use model\entity\MallGoodsComment;
use model\entity\User;
use model\entity\News;
use mmapi\core\Log;
use model\repository\UserRepos;
use mmapi\core\AppException;

class commentUp extends AppApi
{
    protected $comment_id;

    protected function init()
    {
        $this->addParam('comment_id');
    }

    public function run()
    {
        /** @var MallGoodsComment $mallGoodsCommentObj */
        $mallGoodsCommentObj = MallGoodsComment::tryInstance($this->comment_id, ['评论无效', 'COMMENT_UNVALID']);
        if($mallGoodsCommentObj->isDelete()){
            throw new ApiException('评论已经删除','COMMENT_ALREADY_DELETED');
        }
        if(!$mallGoodsCommentObj->isCommentUp($this->user)){
            $mallGoodsCommentObj->setCommentUp($this->user);
        }else{
            throw new ApiException('已经点赞', 'COMMENT_ALREADY_UP');
        }
    }
}