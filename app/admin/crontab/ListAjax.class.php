<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/10/30
 * Time: 09:16
 */

namespace Sdxapp\Admin\Ajax\Crontab;

use Sdxapp\Api\AdminApi;
use Sdxapp\Crontab\crontabTask;

class ListAjax extends AdminApi
{
    public function run()
    {
        $status = file_exists(C('CRONTAB.pid_file_path'));
        $list   = crontabTask::select('*', [], 'id desc', 1, 100);
        $this->success(['list' => $list, 'status' => $status]);
    }

}