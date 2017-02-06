<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/14
 * Time: 17:30
 */
return [
    //项目根目录
    'app_path'   => VPATH . '/app/admin',
    //路由配置
    'dispatcher' => [
        'layer'          => 's',
        'namespace'      => 'app\admin',
        'default_action' => 'index',
    ],
    //登录凭证配置
    'auth'       => [
        'name' => 'auth',
        'key'  => 'sdxapp__abcdefgh',
    ],
];