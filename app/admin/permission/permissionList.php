<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/8/8
 * Time: 00:21
 */

namespace app\admin\permission;

use app\AdminApi;

/**
 * Class listAjax
 *
 * @package Sdxapp\Admin\Ajax\Permission
 */
class listAjax extends AdminApi
{
    protected $group;
    protected $model;

    protected $definition = [
        'group' => [
            self::FIELD_TYPE    => self::TYPE_STRING,
            self::FIELD_REQUIRE => false,
        ],
        'model' => [
            self::FIELD_TYPE => self::TYPE_STRING,
        ],
    ];

    /**
     * @desc   run
     * @author chenmingming
     */
    public function run()
    {
        $this->success(Permission::getListByGroup($this->model, $this->group ?: 'oa'));
    }
}