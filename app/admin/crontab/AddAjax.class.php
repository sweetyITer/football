<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/10/30
 * Time: 15:44
 */

namespace Sdxapp\Admin\Ajax\Crontab;

use Sdxapp\Api\AdminApi;
use Sdxapp\Crontab\crontabTask;

class addAjax extends AdminApi
{
    protected $data;
    protected $definition = [
        'data' => [self::TYPE_STRING, true, 'isJson'],
    ];

    public function run()
    {
        $data = json_decode($this->data, true);
        if ($data['id'] > 0) {
            $obj = new crontabTask($data);
            $obj->save();
        } else {
            crontabTask::add($data['name'], $data['crontab_str'], $data['command'],$data['query'], $data['type'], $data['remark']);
        }

        $this->success();
    }

}