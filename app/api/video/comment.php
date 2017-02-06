<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/5
 * Time: 15:09
 */
namespace app\api\video;

use app\AppApi;
use mmapi\core\ApiParams;
use model\entity\Video;
use model\entity\VideoComment;
use mmapi\core\AppException;

class comment extends AppApi
{
    protected $videoId;
    protected $content;

    protected function init()
    {
        $this->addParam('videoId')->setType(ApiParams::TYPE_INT);
        $this->addParam('content');
    }

    public function run()
    {
        $videoObj = Video::getInstance($this->videoId);
        if (is_null($videoObj)) {
            throw new AppException('该视频Id不存在', 'VIDEO_ID_NOT_EXIST');
        }
        $videoCommentObj = new VideoComment();
        $videoCommentObj->setUser($this->user)
            ->setContent($this->content)
            ->setVideo(Video::getInstance($this->videoId))
            ->save();
    }

}