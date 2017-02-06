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
use Sdxapp\Crontab\crontabMain;
use Sdxapp\Log;
use Sdxapp\Sdxapi;

class StartMainAjax extends AdminApi
{
    public function run()
    {
        if (file_exists(C('CRONTAB.pid_file_path'))) {
            throw new AppException(['定时任务已经开启，请先暂停', 'CRONTAB_STARTED']);
        }
        $crontabObj = new crontabMain(C('CRONTAB'));
        $crontabObj->start();
        usleep(500);
        if (!file_exists(C('CRONTAB.pid_file_path'))) {
            throw new AppException(['开启失败~', 'CRONTAB_START_FAILED']);
        }
        $this->success();
    }

}