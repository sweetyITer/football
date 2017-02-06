<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 14:24
 */
namespace app\api\Post;

use app\AppApi;
use mmapi\core\ApiParams;
use model\entity\Post;
use mmapi\core\AppException;

class setIntro extends AppApi
{
    protected $post_id;

    protected function init()
    {
        $this->addParam('post_id');
    }

    /**
     * run @desc 将帖子设置为推荐/取消设置
     *
     * @author wangjuan
     */
    public function run()
    {
        /** @var Post $postObj */
        $postObj = Post::tryInstance($this->post_id, new AppException('帖子不合法', 'POST_INVALID'));

        $postObj->setIsIntro(!$postObj->getIsIntro())->save();
    }
}
