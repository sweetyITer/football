<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/8/8
 * Time: 23:08
 */

namespace app\admin\nav;

use app\AdminApi;
use mmapi\core\Db;
use model\entity\AdminNavigation;
use model\repository\AdminNavigationRepository;

class nlist extends AdminApi
{
    protected function init()
    {
        // TODO: Implement init() method.
    }

    public function run()
    {
        /** @var AdminNavigationRepository $repos */
        $repos       = AdminNavigation::getRepository();
        $parentNav   = $repos->getParentNav();
        $parentNav[] = [
            'id'   => 0,
            'pid'  => 0,
            'text' => '顶级栏目',
        ];
        $this->set(
            'data',
            [
                'list'       => $repos->getArrayList(),
                'parent_nav' => $parentNav,
            ]
        );
    }

}