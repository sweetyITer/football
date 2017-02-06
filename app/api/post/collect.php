<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 14:11
 */
namespace app\api\Post;

use app\AppApi;
use mmapi\core\AppException;
use model\entity\Post;
use model\entity\User;
use model\repository\UserRepos;

class collect extends AppApi
{
    protected $post_id;

    protected function init()
    {
        $this->addParam('post_id');
    }

    /**
     * run @desc 收藏/取消帖子
     *
     * @author wangjuan
     */
    public function run()
    {
        /** @var Post $postObj */
        $postObj = Post::getInstance($this->post_id);
        if (is_null($postObj) || $postObj->isDelete()) {
            throw new AppException('帖子不合法或者已经删除', 'POST_INVALID');
        }
        /** @var UserRepos $userRepos */
        $userRepos = User::getRepository();
        $this->set('status', $userRepos->postCollect($this->user, $postObj));
    }
}
