<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/5
 * Time: 15:09
 */
namespace app\api\video;

use app\AppApi;
use mmapi\core\Api;
use mmapi\core\Config;
use mmapi\core\Db;
use mmapi\core\ApiParams;
use model\entity\Video;
use mmapi\core\AppException;
use model\entity\VideoComment;

class commentUp extends AppApi
{
    protected $commentId;

    protected function init()
    {
        $this->addParam('commentId')->setType(ApiParams::TYPE_INT);
    }

    public function run()
    {
        /** @var VideoComment $videoCommentObj */
        $videoCommentObj = VideoComment::getInstance($this->commentId);
        if (is_null($videoCommentObj)) {
            throw new AppException('该评论Id不存在', 'COMMENT_ID_NOT_EXIST');
        }
        if ($this->checkRepeat($this->commentId, $this->user->getId()) != null) {
            $this->cancelUp($this->commentId, $this->user->getId());
            $videoCommentObj
                ->setUpCount($videoCommentObj->getUpCount() - 1)
                ->save();
        } else {
            Db::create()
                ->sqlBuilder()
                ->insert('video_comment_up')
                ->set('user_id')->value($this->user->getId())
                ->set('comment_id')->value($this->commentId)
                ->exec();
            $videoCommentObj
                ->setUpCount($videoCommentObj->getUpCount() + 1)
                ->save();
        }
    }

    public function checkRepeat($commentId, $userId)
    {
        $data = Db::create()->sqlBuilder()
            ->select('comment_id,user_id')
            ->from('video_comment_up')
            ->where('comment_id')
            ->eq($commentId)
            ->andWhere('user_id')
            ->eq($userId)
            ->fetch();

        return $data;
    }

    public function cancelUp($commentId, $userId)
    {
        $rs = Db::create()->sqlBuilder()
            ->delete('video_comment_up')
            ->where('comment_id')->eq($commentId)
            ->andWhere('user_id')->eq($userId)
            ->exec();
        if ($rs <= 0) {
            throw new AppException('取消收藏失败', 'CANCEL_COLLECT_FAIlED');
        }
    }
}