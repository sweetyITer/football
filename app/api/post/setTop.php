<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 14:22
 */
namespace app\api\post;

use app\AppApi;
use mmapi\core\ApiParams;
use model\entity\Post;
use mmapi\core\AppException;

class setTop extends AppApi
{
    protected $post_id;

    protected function init()
    {
        $this->addParam('post_id');
    }

    /**
     * run @desc  置顶帖子
     * @author wangjuan
     */
    public function run()
    {
        /** @var Post $postObj */
        $postObj = Post::tryInstance($this->post_id, new AppException('帖子不合法', 'POST_INVALID'));

        $postObj->setIsTop(!$postObj->getIsTop())->save();
    }
}
