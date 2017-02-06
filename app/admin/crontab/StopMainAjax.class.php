<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/10/30
 * Time: 11:55
 */

namespace Sdxapp\Admin\Ajax\Crontab;

use Sdxapp\Api\AdminApi;
use Sdxapp\AppException;

class StopMainAjax extends AdminApi
{
    public function run()
    {
        if (!file_exists(C('CRONTAB.pid_file_path'))) {
            throw new AppException(['定时任务未开启', 'CRONTAB_NOT_STARTED']);
        }
        if (!unlink(C('CRONTAB.pid_file_path'))) {
            throw new AppException(['删除pid文件失败，请检查pid文件权限', 'CRONTAB_PID_FILE_ERROR']);
        }
        $this->success();
    }

}