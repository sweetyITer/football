<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/14
 * Time: 17:15
 */

namespace app\api;

use mmapi\core\Api;
use mmapi\core\Log;
use mmapi\core\Db;
use model\entity\User;

class index extends Api
{
    protected function init()
    {
        // TODO: Implement init() method.
//        ApiParams::create('id')->add($this);
    }

    public function run()
    {
        $data = Db::create()->query('select * from post where user_id = ' . 1)->fetch();
        $this->set('da',$data);
        $this->set('data', 'helloworld11');
        //增
        /* $db = Db::create()->sqlBuilder()
             ->update("mall_user")*/
        /*  $userObj = new User();
          $userObj->setEmail('13916963863@139.com')
              ->setFaceImg('1111')
              ->setUserName("xiaomi123")
              ->setGuid("1234")
              ->setPhone('13916963863')
              ->setUpdateTime(new \DateTime())
              ->setLastIp('127.0.0.1')
              ->setSalt('12341')
              ->save();*/
        //删
        /*   $u = User::getInstance(3);
           $u->remove();*/

        //改 如果成功返回1
        $rs = Db::create()->sqlBuilder()
            ->update('mall_user')
            ->where('id')->eq(6)
            ->set('nick_name')->value('kimi12312')
            ->set('last_login')->expValue('date_format(now(), "%Y-%m-%d %H:%i:%s")')
            ->exec();

        $this->set('rs', $rs);
        $id = 1;
        //查
        $data = Db::create()->query('select nick_name from `mall_user` where id ="' . $id . '"')
            ->fetch();
        $this->set('data132312312', $data);

        /*  $nick_name*/

    }

}