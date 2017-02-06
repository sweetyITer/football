<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/12
 * Time: 13:38
 */
namespace app\api\Information;

use app\AppApi;
use model\entity\News;

class newList extends AppApi
{
    protected $group_id;
    protected $page;
    protected $size;

    protected function init()
    {
        $this->addParams(['group_id', 'page', 'size']);
      //  $this->addParam('auth')->setRequire(false);
        $this->get('auth')->setRequire(false);
    }

    /**
     * run @desc 资讯列表
     *
     * @author wangjuan
     */
    public function run()
    {
        $this->page || $this->page = 1;
        $this->size || $this->size = 3;
        $this->group_id || $this->group_id = 'zhongchaozixun';
        $list = News::getList($this->group_id, $this->page, $this->size);
        $this->set('data', $list);
    }
}