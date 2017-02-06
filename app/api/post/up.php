<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 14:18
 */
namespace app\api\post;

use app\AppApi;
use mmapi\core\AppException;
use model\entity\User;
use model\entity\Post;
use model\repository\UserRepos;
use mmapi\cache;

class up extends AppApi
{
    protected $post_id;

    protected function init()
    {
        $this->addParam('post_id');
    }

    /**
     * run @desc 点赞帖子
     *
     * @author wangjuan
     */
    public function run()
    {
        //判断用户是否合法
        /** @var Post $postObj */
        $postObj = Post::getInstance($this->post_id);
        if (is_null($postObj) || $postObj->isDelete()) {
            throw new AppException('帖子不合法或是已经删除', 'POST_INVALID');
        }
        /** @var UserRepos $userRepos */
        $userRepos = User::getRepository();

        if (!$userRepos->isPostUp($this->user, $postObj)) {
            $userRepos->upPost($this->user, $postObj);
        } else {
            throw new AppException('帖子已经点赞过', 'POST_ALREADY_UP');
        }
    }
}