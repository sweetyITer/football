<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/10/30
 * Time: 11:15
 */

namespace Sdxapp\Admin\Ajax\Crontab;

use Sdxapp\Api\AdminApi;
use Sdxapp\AppException;
use Sdxapp\Crontab\crontabTask;

/**
 * Class stopAjax 暂停某个定时任务 或者所有任务
 *
 * @package Sdxapp\Admin\Ajax\Crontab
 */
class stopAjax extends AdminApi
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
        if ($taskObj->getStatus() != crontabTask::STATUS_WAIT) {
            throw new AppException(['该任务状态非法，暂时不能暂停', 'CRONTAB_TASK_STATUS_INVALID']);
        }
        $taskObj->setStop();
        $this->record('system.crontab.stop', ["暂停了任务[%s] %s", $taskObj->getId(), $taskObj->getName()]);
        $this->success();
    }

}