<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/10
 * Time: 15:50
 */
namespace app\api\quan;

use app\AppApi;
use mmapi\core\ApiParams;
use model\entity\Post;
use model\entity\Quan;
use mmapi\core\AppException;

class morePost extends AppApi
{
    protected $quan_id;
    protected $page;
    protected $size;

    protected function init()
    {
        $this->addParam('quan_id');
        $this->addParam('page')->setRequire(ApiParams::TYPE_INT);
        $this->addParam('size')->setRequire(ApiParams::TYPE_INT);
    }

    /**
     * run @desc 圈子详情
     *
     * @author wangjuan
     */
    public function run()
    {
        $this->page || $this->page = 2;
        $this->size || $this->size = 5;
        /** @var Quan $quanObj */
        $quanObj = Quan::tryInstance($this->quan_id, new AppException('圈子不合法', 'QUAN_INVALID'));
        $data    = [

            'list' => Post::getQuanList($this->user, $quanObj, $this->page, $this->size),
            
        ];
        $this->set('data', $data);
    }

}
