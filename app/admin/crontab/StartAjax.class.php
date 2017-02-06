<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/10/30
 * Time: 13:26
 */

namespace Sdxapp\Admin\Ajax\Crontab;

use Sdxapp\Api\AdminApi;
use Sdxapp\AppException;
use Sdxapp\Crontab\crontabTask;

class StartAjax extends AdminApi
{
    protected $id;

    protected $definition = [
        'id' => [self::TYPE_INT],
    ];

    public function run()
    {
        $info = crontabTask::find($this->id);
        if (!$info) {
            throw new AppException(['该定时任务不存在~', 'CRONTAB_TASK_NOT_EXIST']);
        }
        $taskObj = new crontabTask($info);
        if ($taskObj->getStatus() == crontabTask::STATUS_WAIT) {
            throw new AppException(['该任务已经开启', 'CRONTAB_TASK_STARTED']);
        }
        $taskObj->setWait();
        $this->record('system.crontab.start', ["开启了任务[%s] %s", $taskObj->getId(), $taskObj->getName()]);
        $this->success();
    }
}