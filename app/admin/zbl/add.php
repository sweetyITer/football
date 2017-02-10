<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/19
 * Time: 20:18
 */

namespace app\admin\zbl;

use app\AdminApi;
use mmapi\core\Api;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use mmapi\core\Db;
use model\entity\Attribute;
use model\entity\AttributeSet;
use model\entity\Category;
use model\entity\ZblIntroModule;

class add extends AdminApi
{
    protected $title;
    protected $type;
    protected $orderNum;
    protected $isOpen;
    protected $content;
    protected $isDelete;

    protected function init()
    {
        $this->addParam('title');
        $this->addParam('type');
        $this->addParam('orderNum')->setType(ApiParams::TYPE_INT);
        $this->addParam('isOpen');
        $this->addParam('content')->setType(ApiParams::TYPE_ARRAY);
        $this->addParam('isDelete')->setType(ApiParams::TYPE_STRING)->setRequire(false)->setDefault(false);
        /*$this->denyResubmit();*/
    }

    public function run()
    {
        $content = json_encode($this->content);
        $zblObj  = new ZblIntroModule();
        $zblObj
            ->setTitle($this->title)
            ->setType($this->type)
            ->setOrderNum($this->orderNum)
            ->setIsOpen($this->isOpen)
            ->setContent($content)
            ->save();
    }
}