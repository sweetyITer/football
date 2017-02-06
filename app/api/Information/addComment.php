<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/13
 * Time: 17:07
 */
namespace app\api\Information;

use app\AppApi;
use model\entity\NewsComment;
use model\entity\News;

class addComment extends AppApi
{
    protected $news_id;
    protected $content;

    protected function init()
    {
        $this->addParams(['news_id', 'content']);
    }

    public function run()
    {
        /** @var news $newsObj */
        $newsObj        = News::tryInstance($this->news_id, ['新闻无效', 'NEWS_UNVALID']);
        $newsCommentObj = new NewsComment();
        $newsCommentObj
            ->setUserId($this->user->getId())
            ->setContent($this->content)
            ->setNewsId($newsObj->getId())
            ->save();
        //资讯的评论数增加1
        $newsObj->setCommentCount((int)$newsObj->getCommentCount() + 1)
            ->save();
    }

}
