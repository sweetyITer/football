<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/21
 * Time: 21:11
 */

namespace model;

use mmapi\core\AppException;
use mmapi\core\Db;
use mmapi\core\Model;

class footballModel extends Model
{

    /**
     * @desc   tryOne 获取一个对象 不存在则抛出异常
     * @author chenmingming
     *
     * @param int $id 主键id
     *
     * @return object
     * @throws AppException
     */
    static public function tryOne($id)
    {
        $class = get_called_class();
        $obj   = Db::create()->find($class, $id);
        if (is_null($obj)) {
            throw new AppException($class . "[id:{$id}]不存在", 'INSTANCE_NOT_EXIST');
        }

        return $obj;
    }
}