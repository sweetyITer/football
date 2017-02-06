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

class videoUp extends AppApi
{
    protected $videoId;

    protected function init()
    {
        $this->addParam('videoId')->setType(ApiParams::TYPE_INT);
    }

    public function run()
    {
        /** @var Video $videoObj */
        $videoObj = Video::getInstance($this->videoId);
        if (is_null($videoObj)) {
            throw new AppException('该视频Id不存在', 'VIDEO_ID_NOT_EXIST');
        }
        if ($this->checkRepeat($this->videoId, $this->user->getId()) != null) {
            $this->cancelUp($this->videoId, $this->user->getId());
            $videoObj
                ->setUpCount($videoObj->getUpCount() - 1)
                ->save();
        } else {
            Db::create()
                ->sqlBuilder()
                ->insert('video_up')
                ->set('user_id')->value($this->user->getId())
                ->set('video_id')->value($this->videoId)
                ->exec();
            $videoObj
                ->setUpCount($videoObj->getUpCount() + 1)
                ->save();
        }
    }

    public function checkRepeat($videoId, $userId)
    {
        $data = Db::create()->sqlBuilder()
            ->select('video_id,user_id')
            ->from('video_up')
            ->where('video_id')
            ->eq($videoId)
            ->andWhere('user_id')
            ->eq($userId)
            ->fetch();

        return $data;
    }

    public function cancelUp($videoId, $userId)
    {
        $rs = Db::create()->sqlBuilder()
            ->delete('video_up')
            ->where('video_id')->eq($videoId)
            ->andWhere('user_id')->eq($userId)
            ->exec();
        if ($rs <= 0) {
            throw new AppException('取消收藏失败', 'CANCEL_COLLECT_FAIlED');
        }
    }
}