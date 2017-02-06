<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/14
 * Time: 20:34
 */

$vpath = dirname(dirname(__DIR__));
require_once $vpath . '/vendor/autoload.php';
mmapi\core\Config::set('vpath', $vpath);
mmapi\core\Config::set('conf_file', ['conf.php', 'admin.php', 'debug.php']);
mmapi\core\App::start();