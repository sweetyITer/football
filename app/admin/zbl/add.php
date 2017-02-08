<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/19
 * Time: 20:18
 */

namespace app\admin\attrset;

use app\AdminApi;
use mmapi\core\Api;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use mmapi\core\Db;
use model\entity\Attribute;
use model\entity\AttributeSet;
use model\entity\Category;
use model\entity\ZblIntro;

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
        $this->addParam('isOpen');
        $this->addParam('content')->setType(ApiParams::TYPE_STRING);
        $this->addParam('isDelete')->setType(ApiParams::TYPE_STRING)->setRequire(false)->setDefault(false);
        $this->denyResubmit();
    }

    public function run()
    {
        $zblObj = new ZblIntro();
        $zblObj
            ->setTitle($this->title)
            ->setType($this->type)
            ->setOrderNum($this->orderNum)
            ->setIsOpen($this->isOpen)
            ->setContent($this->content)
            ->setIsDelete($this->isDelete)
            ->save();
    }
}