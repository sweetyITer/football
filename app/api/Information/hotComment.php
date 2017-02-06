<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/16
 * Time: 15:28
 */
namespace app\api\Information;

use app\AppApi;
use model\entity\News;
use model\entity\NewsComment;

class hotComment extends AppApi
{
    protected $news_id;
    protected $page;

    protected function init()
    {
        $this->addParams(['news_id', 'page']);
        //$this->addParam('auth')->setRequire(false);
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        $this->page || $this->page = 2;
        /** @var News $newsObj */
        $newsObj = News::tryInstance($this->news_id, ['咨询无效', 'NEWS_UNVALID']);
        $list    = NewsComment::getList($newsObj, $this->page, $this->user ? $this->user : null);
        $this->set('data', $list);
    }

}