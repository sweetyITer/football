<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/5
 * Time: 15:39
 */
namespace app\api\quan;

use app\AppApi;
use mmapi\core\ApiParams;
use mmapi\core\Db;
use model\entity\Post;
use model\entity\Quan;
use mmapi\core\AppException;

class info extends AppApi
{
    protected $quan_id;
    protected $page;
    protected $size;

    protected function init()
    {
        $this->addParam('quan_id');
        $this->addParam('page')->setRequire(ApiParams::TYPE_INT);
        $this->addParam('size')->setRequire(ApiParams::TYPE_INT);
        $this->get('auth')->setRequire(false);
    }

    /**
     * run @desc 圈子详情
     *
     * @author wangjuan
     */
    public function run()
    {
        $this->page || $this->page = 1;
        $this->size || $this->size = 3;
        /** @var Quan $quanObj */
        $quanObj = Quan::tryInstance($this->quan_id, new AppException('圈子不合法', 'QUAN_INVALID'));
        //帖子数据
        $data = [
            'info'           => [
                'title'        => $quanObj->getTitle(),
                'icon'         => $quanObj->getIcon(),
                'follow_count' => $quanObj->getFollowCount(),
                'post_count'   => $quanObj->getPostCount(),
            ],
            'activeHeadpics' => Post::getTodayActiveHeadPics($this->quan_id),
            'post'           => [
                'list' => Post::getQuanList($this->user ? $this->user : null, $quanObj, $this->page, $this->size),
            ],
        ];
        $this->set('data', $data);
    }
}
