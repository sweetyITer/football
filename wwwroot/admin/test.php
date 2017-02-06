<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/13
 * Time: 13:33
 */

//define('HONG', __LINE__);

set_exception_handler(function () {
    echo "<pre>-->";
    print_r(HONG);
    echo "<--@in ".__FILE__." on line ".__LINE__."\n";
});

define('HONG', __LINE__);


throw new \Exception("aa");