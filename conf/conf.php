<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/14
 * Time: 17:13
 */
return [
    //数据库配置
    'db'    => [
        'default' => [
            'is_dev_mode' => true,
            'conn'        => [
                'driver'   => 'pdo_mysql',
                'dbname'   => 'football',
                'host'     => '10.168.57.250',
                'user'     => 'football',
                'password' => 'football123sdxapp',
            ],
            'path'        => [
                VPATH . '/model/xml',
                VPATH . '/model/mallxml',
            ],
        ],
    ],
    //日志配置
    'log'   => [
        'status'      => true,
        'time_format' => ' Y-m-d H:i:s ',
        'togbk'       => true,
        'filepath'    => '/dev/shm/football.cutlog',
        'color'       => [
            'sql'   => \mmapi\log\File::COLOR_GREY,
            'error' => \mmapi\log\File::COLOR_RED,
            'info'  => \mmapi\log\File::COLOR_BLUE,
        ],
    ],
    //图片配置
    'image' => [
        'default' => [
            'type'              => 'oss',
            'domain'            => 'img.hotwheels.sdxapp.com',
            'access_key_id'     => 'LTAIaGWidTOAESgd',
            'access_secret_key' => '5QAQyFa7me2R59fOBmX91w3N3wA4tQ',
            'end_point'         => 'oss-cn-hangzhou-internal.aliyuncs.com',
            'bucket'            => 'hotwheels',
            'input_name'        => 'file_data',
            'legal_dir'         => [
                'goods',//人员头像
                'category',//人员头像
                'brand',//后台管理员头像
                'user',
            ],
        ],
    ],
    //缓存配置
    'cache' => [
        'type'    => 'complex',
        'default' => [
            'type'    => 'Memcached',
            'host'    => '127.0.0.1',
            'port'    => 11311,
            'expire'  => 0,
            'timeout' => 5, // 超时时间（单位：毫秒）
            'prefix'  => '',
        ],

    ],
    'CTY_USER_NAME'   => 'shxsdz-1',
    'CTY_USER_PASSWD' => '348dce'
];