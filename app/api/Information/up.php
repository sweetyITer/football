<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/13
 * Time: 14:31
 */
namespace app\api\Information;

use app\AppApi;
use model\entity\User;
use model\entity\News;
use model\repository\UserRepos;
use mmapi\core\AppException;

class up extends AppApi
{
    protected $news_id;

    protected function init()
    {
        $this->addParams(['news_id']);
    }

    /**
     * run @desc 资讯列表
     *
     * @author wangjuan
     */
    public function run()
    {
        /** @var UserRepos $userRepos */
        $userRepos = User::getRepository();
        /** @var News $newObj */
        $newObj = News::tryInstance($this->news_id,  new AppException('该资讯不存在', 'NEWS_UNVALID'));
        if($newObj->getIsDelete()){
            throw new AppException("资讯已经删除","NEWS_DELETED");
        }
        if(!$userRepos->isNewsUp($this->user, $newObj)){
            $userRepos->setNewsUp($this->user, $newObj);
        }else{
            throw new AppException("已经点赞","ALREADY_UP");
        }
    }

}