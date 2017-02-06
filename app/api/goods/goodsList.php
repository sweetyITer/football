<?php
namespace app\api\goods;

use app\AppApi;
use model\entity\Goods;

class goodsList extends AppApi
{
    protected $cid;
    protected $page;
    protected $size;

    protected function init()
    {
        $this->addParams(['cid', 'page', 'size']);
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {
        $this->page || $this->page = 1;
        $this->size || $this->size = 4;
        $list = Goods::getList($this->cid, $this->page, $this->size);
        $this->set('data', $list);
    }

}