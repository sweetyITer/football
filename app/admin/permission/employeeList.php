<?php
/**
 * Created by PhpStorm.
 * User: mds
 * Date: 2016/8/30
 * Time: 15:19
 */

namespace app\admin\permission;

use app\AdminApi;
use mmapi\core\ApiParams;
use mmapi\core\Db;
use model\entity\AdminMaster;
use model\entity\AdminMasterPermission;
use model\entity\AdminPermission;

class employeeList extends AdminApi
{
    protected $id;//权限id
    protected $page;//页码

    protected function init()
    {
        $this->addParam('id')->setType(ApiParams::TYPE_INT);
        $this->addParam('page')
            ->setType(ApiParams::TYPE_INT)
            ->setRequire(false)
            ->setDefault(1);
    }

    public function run()
    {
//        $str = 'SELECT t0.group AS group_1, t0.add_time AS add_time_2, t0.id AS id_3, t0.permission_id AS permission_id_4, t0.master_id AS master_id_5 FROM admin_master_permission t0 WHERE t0.id = ?';
//        $str = str_replace('?', '"%s"', $str);
//        $str = vsprintf($str, [123]);
//        $this->set('data', $str);


//        $table = 'admin_master_permission as p left join admin_master as m ON p.master_id = m.id';
//        $count = DB::M()
//            ->table($table)
//            ->where([
//                'p.permission_id' => $this->id,
//            ])
//            ->count();
//        Log::write($count, 'count');
//        $data = [];
//        $size = 5;
//        if ($count > 0) {
//            $page = max((int)$this->page, 1);
//            $data = DB::M()
//                ->field('m.nick_name, m.id')
//                ->table($table)
//                ->where([
//                    'p.permission_id' => $this->id,
//                ])
//                ->limit(($page - 1) * $size, $size)
//                ->select();
//        }
//
//        if (!$data) {
//            throw new AppException('没有该权限的员工', 78786);
//        }
//        $this->success([
//            'list'        => $data,
//            'total_count' => $count,
//        ]);

    }
}