<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 16:39
 */
namespace app\api\post;

use app\AppApi;
use model\entity\Post;
use model\entity\Quan;
use mmapi\core\AppException;

class add extends AppApi
{
    protected $title;
    protected $text;
    protected $imgs;
    protected $quan_id;

    protected function init()
    {
        $this->addParams(['title', 'text', 'quan_id', 'imgs']);
    }

    /**
     * run @desc 添加帖子
     *
     * @author wangjuan
     */
    public function run()
    {
        $postObj = new Post();

        /** @var Quan $quanObj */
        $quanObj = Quan::tryInstance($this->quan_id, new AppException('圈子不合法'));
        $postObj
            ->setTitle($this->title)
            ->setText($this->text)
            ->setImgs($this->imgs)
            ->setContent()
            ->setQuan($quanObj)
            ->setUser($this->user)
            ->save();
        $this->set('post_id', $postObj->getId());
    }
}
