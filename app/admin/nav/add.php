<?php
/**
 * Created by PhpStorm.
 * User: mds
 * Date: 2016/8/29
 * Time: 16:50
 */

namespace app\admin\nav;

use app\AdminApi;
use mmapi\core\AppException;
use mmapi\core\Db;
use model\entity\AdminNavigation;

class add extends AdminApi
{
    protected $id; //导航id
    protected $old_id; //导航就id
    protected $pid;//父id
    protected $text;//导航名称
    protected $url;//地址
    protected $icon;//图标
    protected $target;//打开方式
    protected $group;//分组
    protected $orderNum;//排序

    protected function init()
    {
        $this->addParams(
            [
                'text',
                'url',
            ]);
        $this->addParam('id')->setRequire(false);
        $this->addParam('pid')->setRequire(false)->setDefault(0);
        $this->addParam('icon')->setRequire(false)->setDefault('');
        $this->addParam('group')->setRequire(false);
        $this->addParam('status')->setRequire(false)->setDefault('open');
        $this->addParam('orderNum')->setRequire(false)->setDefault(99);
        $this->addParam('target')->setRequire(false)->setDefault(AdminNavigation::TARGET_SELF);

    }

    public function run()
    {
        if ($this->id) {
            /** @var AdminNavigation $adminNavigation */
            $adminNavigation = AdminNavigation::getInstance($this->id);
            if (is_null($adminNavigation)) {
                throw new AppException("该导航不存在", 'NAVIGATION_NOT_FUND');
            }
        } else {
            $adminNavigation = new AdminNavigation();
        }
        $adminNavigation
            ->setGroup($this->group)
            ->setIcon($this->icon)
            ->setPid($this->pid)
            ->setOrderNum($this->orderNum)
            ->setTarget($this->target)
            ->setUrl($this->url)
            ->setStatus($this->status)
            ->setText($this->text)
            ->save();
    }
}