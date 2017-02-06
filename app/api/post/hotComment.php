<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/9
 * Time: 15:16
 */
namespace app\api\Post;

use app\AppApi;
use mmapi\core\ApiParams;
use mmapi\core\Db;
use mmapi\core\Log;
use model\entity\User;
use model\entity\Post;
use model\entity\PostComment;
use model\repository\UserRepos;

use mmapi\core\AppException;

class hotComment extends AppApi
{
    protected $post_id;
    protected $page;

    protected function init()
    {
        $this->addParam('post_id');
        $this->addParam('page')->setRequire(ApiParams::TYPE_INT)->setDefault(1);
        $this->addParam('auth')->setRequire(false);
    }

    /**
     * run @desc 帖子详情
     *
     * @author wangjuan
     */
    public function run()
    {
        $this->page || $this->page = 2;
        /** @var Post $postObj */
        $postObj     = Post::tryInstance($this->post_id, new AppException('帖子不合法', 'POST_INVALID'));
        $commentList = PostComment::getCommentList($postObj, $this->page, $this->user ? $this->user : null);
        $return      = [
            "list" => $commentList,
        ];

        $this->set('data', $return);
    }
}
