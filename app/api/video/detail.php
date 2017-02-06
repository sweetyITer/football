<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 10:15
 */
namespace app\api\video;

use app\AppApi;
use mmapi\core\Api;
use mmapi\core\AppException;
use mmapi\core\Config;
use mmapi\core\Db;
use mmapi\core\ApiParams;
use model\entity\Video;

class detail extends AppApi
{
    protected $videoId;

    protected function init()
    {
        $this->addParam('videoId')->setType(ApiParams::TYPE_INT);
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        /** @var Video $videoObj */
        $videoObj = Video::getInstance($this->videoId);
        if (is_null($videoObj)) {
            throw new AppException('该视频id不存在', 'VIDEO_NOT_EXIST');
        }
        $info = [
            'content' => $videoObj->getContent(),
        ];
        $this->set('info', $info);
    }

}
