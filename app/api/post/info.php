<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 14:10
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

class info extends AppApi
{
    protected $post_id;
    //  protected $size;
    protected $page;

    protected function init()
    {
        $this->addParam('post_id');
        $this->addParam('page');
      //  $this->addParam('auth')->setRequire(false);
        $this->get('auth')->setRequire(false);
    }

    /**
     * run @desc 帖子详情
     *
     * @author wangjuan
     */
    public function run()
    {
        $this->page || $this->page = 1;
        /** @var Post $postObj */
        $postObj = Post::tryInstance($this->post_id, new AppException('帖子不合法', 'POST_INVALID'));
        if ($postObj->isDelete()) {
            throw new AppException('帖子已经删除', 'POST_DELETED_INVALID');
        }
        //帖子总评论数
        $commentCount = Db::create()->sqlBuilder()
            ->select('count(*) as count')
            ->from('post_comment')
            ->where('post_id')
            ->eq($postObj->getId())
            ->getField('count');

        /** @var UserRepos $userRepos */
        if ($this->user) {
            $userRepos = User::getRepository();
        } else {
            $userRepos = null;
        }
        $return = [
            "info"         => [
                'id'        => $postObj->getId(),
                'isUp'      => $userRepos ? $userRepos->isPostUp($this->user, $postObj) : false,  //帖子是否点赞
                'isCollect' => $userRepos ? $userRepos->isPostCollect($this->user, $postObj) : false, //帖子是否收藏
                'author'    => $postObj->getUser()->getNickName(),
                'face_img'  => $postObj->getUser()->getFaceImg(),
                'text'      => $postObj->getText(),
                'imgs'      => $postObj->getImgs(),
                'title'     => $postObj->getTitle(),
                'add_time'  => $postObj->getAddTime(),
            ],
            "comment_list" => [
                "list"       => PostComment::getCommentList($postObj, $this->page, $this->user ? $this->user : null),
                "totalCount" => $commentCount,
                //获取前五个人的头像
                'face_imgs'  => PostComment::getFaceImgs($postObj, $this->page),
            ],
        ];
        $this->set('data', $return);
    }
}
