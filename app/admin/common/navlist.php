<?php
namespace app\admin\common;

use app\AdminApi;
use mmapi\core\Db;
use model\entity\AdminNavigation;
use model\repository\AdminNavigationRepository;

/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/7/3
 * Time: 08:53
 */
class navlist extends AdminApi
{
    protected function init()
    {

    }

    /**
     * run desc?
     *
     * @author chenchao
     */
    public function run()
    {

        /** @var AdminNavigationRepository $respository */
        $respository = AdminNavigation::getRepository();
        $data        = [];
        /** @var  AdminNavigation $p */
        foreach ($respository->getList() as $p) {
            $tmp = [
                'id'   => $p->getId(),
                'icon' => $p->getIcon(),
                'text' => $p->getText(),
                'url'  => $p->getUrl(),
                'list' => [],
            ];
            foreach ($p->getChildrens() as $c) {
                $tmp['list'][] = [
                    'id'   => $c->getId(),
                    'icon' => $c->getIcon(),
                    'text' => $c->getText(),
                    'url'  => $c->getUrl(),
                ];
            }
            array_push($data, $tmp);
        }
        $this->set('data', $data);
    }

}