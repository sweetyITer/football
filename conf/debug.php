<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/2
 * Time: 20:01
 */
return [
    'debug' => false,
    //接口配置
    'api'   => [
        'debug' => false,
    ],
    //日志配置
    'log'   => [
        'status'      => true,
        'time_format' => ' Y-m-d H:i:s ',
        'togbk'       => true,
        'filepath'    => '/dev/shm/football_wangjuan.cutlog',
        'color'       => [
            'sql'   => \mmapi\log\File::COLOR_GREY,
            'error' => \mmapi\log\File::COLOR_RED,
            'info'  => \mmapi\log\File::COLOR_BLUE,
        ],
    ],
];