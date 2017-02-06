<?php
/**
 * Created by PhpStorm.
 * User: mds
 * Date: 2016/8/30
 * Time: 14:46
 */

namespace app\admin\nav;

use app\AdminApi;
use mmapi\core\ApiParams;
use mmapi\core\AppException;
use mmapi\core\Db;
use model\entity\AdminNavigation;

class del extends AdminApi
{
    protected $id;//导航id

    protected function init()
    {
        $this->addParam('id')->setType(ApiParams::TYPE_INT);
    }

    public function run()
    {
        $adminNav = AdminNavigation::getInstance($this->id);
        if (is_null($adminNav)) {
            throw new AppException("该导航不存在", "NAV_NOT_EXIST");
        }
        $this->db->remove($adminNav);
    }
}