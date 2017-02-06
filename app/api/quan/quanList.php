<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/4
 * Time: 14:10
 */
namespace app\api\quan;

use app\AppApi;
use mmapi\core\ApiParams;
use mmapi\core\Db;
use mmapi\core\AppException;

class quanList extends AppApi
{
    protected $group;

    protected function init()
    {
        $this->addParam('group');
        $this->get('auth')->setRequire(false);
    }

    /**
     * run @desc 圈子列表
     *
     * @author wangjuan
     */
    public function run()
    {
        if (!empty($this->group) && !in_array($this->group, ['east', 'west', 'north', 'south'])) {
            throw new AppException('区域无效', 'GROUP_INVALID');
        }
        if (empty($this->group)) {
            $this->group = 'north';
        }
        $data = Db::create()->sqlBuilder()
            ->select('title, icon')
            ->from('quan')
            ->where("`group`")
            ->eq($this->group)
            ->fetchAll();
        $this->set('data', [
            'list'  => $data,
            'count' => count($data),
        ]);
    }
}
