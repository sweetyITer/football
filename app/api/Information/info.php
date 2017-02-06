<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/13
 * Time: 17:05
 */
namespace app\api\Information;

use app\AppApi;
use mmapi\api\ApiException;
use model\entity\NewsComment;
use model\entity\User;
use model\entity\News;
use model\repository\UserRepos;

class info extends AppApi
{
    protected $news_id;
    protected $page;

    protected function init()
    {
        $this->addParams(['news_id', 'page']);
     //   $this->addParam('auth')->setRequire(false);
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        /** @var News $newObj */
        $newObj = News::tryInstance($this->news_id, ['资讯无效', 'NEWS_UNVALID']);
        if ($newObj->getIsDelete()) {
            throw new ApiException('资讯已经被删除', 'NEWS_ALREADY_DELETED');
        }
        //打开一次详情页,资讯浏览量加1
        $newObj->setViewCount((int)$newObj->getViewCount() + 1)->save();

        if($this->user){
            /** @var UserRepos $userRepos */
            $userRepos = User::getRepository();
        }else{
            $userRepos = null;
        }
        $this->page || $this->page = 1;
        $return = [
            "info"    => [
                'id'         => $newObj->getId(),
                "title"      => $newObj->getTitle(),
                "add_time"   => $newObj->getAddTime(),
                /** @var User $userObj */
                "author"     => User::getInstance($newObj->getAuthor())->getId(),
                "text"       => $newObj->getText(),
                "imgs"       => $newObj->getImgs(),
                'is_up'      => $userRepos ? $userRepos->isNewsUp($this->user, $newObj) : false,
                'is_collect' => $userRepos ? $userRepos->isNewsCollect($this->user, $newObj) : false,
            ],
            "comment" => [
                "comment_count" => $newObj->getCommentCount(),

                "list"      => NewsComment::getList($newObj, $this->page, $this->user ? $this->user : null),
                //获取评论者的头像
                "face_imgs" => NewsComment::getFaceImgs($newObj, $this->page),
            ],
        ];
        $this->set('data', $return);

    }

}
