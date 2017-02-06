<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/14
 * Time: 17:30
 */
return [
    'app_path'   => VPATH . '/app/wx',
    'dispatcher' => [
        'layer'          => 's',
        'namespace'      => 'app\api',
        'default_action' => 'index',
    ],
    'api'        => [
        'secret' => '37b4e2d82900d5e94b8da524fbeb33c0',
    ],
];