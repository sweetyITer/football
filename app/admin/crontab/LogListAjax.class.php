<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/10/30
 * Time: 16:37
 */

namespace Sdxapp\Admin\Ajax\Crontab;

use Sdxapp\Api\AdminApi;
use Sdxapp\DB;

class LogListAjax extends AdminApi
{
    public function run()
    {
        $list = DB::M()
            ->table('admin_crontab_log')
            ->order('id desc')
            ->limit(0, 50)
            ->select();
        $this->success($list);
    }

}