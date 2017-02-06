<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/2
 * Time: 20:22
 */

namespace app\api\common;

use app\AppApi;
use mmapi\core\Api;
use mmapi\core\Config;
use mmapi\core\Db;
use mmapi\tool\ModelXmlBuilder;
use model\entity\Post;
use model\entity\Quan;
use model\entity\User;

class test extends AppApi
{
    protected function init()
    {
        $this->get('auth')->setRequire(false);
    }

    public function run()
    {


     /*   $this->set('data', [
            'dddd' => 1111,
        ]);
        $this->set('auth', User::getInstance(1)->getAuth());*/

     //   $this->set('test', 1111);

        $obj = new ModelXmlBuilder();
        $obj->setDb(Db::create())
            ->setTableName('news')
            ->setNamespace('model\\entity')
            ->builder(__DIR__);

     //   $this->set('test', User::getInstance(1)->getAuth());
 

//        $quan = new Quan();
//        $quan->setTitle('皇家马德里')
//            ->setGroup('east')
//            ->setIcon('1111')
//            ->save();
//
//        $post = new Post();
//
//        $post->setTitle('test122')
//            ->setContent('1123123')
//            ->setQuan($quan)
//            ->setUser(User::getInstance(1))
//            ->save();

        /** @var User $u */
//        $u = User::getInstance(2);
//        $u->remove();
//

//        $userObj = new User();
//        $userObj->setEmail('13916963863@139.com')
//            ->setFaceImg('1111')
//            ->setGuid('13123123')
//            ->setIsLock(1)
//            ->setMoney(100)
//            ->setNickName('mingming')
//            ->setUserName('13916963863')
//            ->setSex(1)
//            ->setPhone('13916963863')
//            ->setUpdateTime(new \DateTime())
//            ->setLastIp('127.0.0.1')
//            ->setSalt('12341')
//            ->save();

//        /** @var User $user2 */
//        $user2 = User::getInstance(2);
//        $user2->setNickName('wangjuan')
//            ->save();

     /*   //改
        Db::create()->sqlBuilder()
            ->update('mall_user')
            ->where('id')->eq(2)
            ->set('nick_name')->value('suijing')
            ->set('last_login')->expValue('now()')
            ->exec();

        /** @var User $user */
     /*   $user = User::getInstance(1);
        $this->set('nickname', $user->getNickName());

        //查
        $nick_name = Db::create()->sqlBuilder()
            ->select('nick_name')
            ->from('mall_user')
            ->where('id')->eq(1)
            ->getField('nick_name');
        $this->set('nick_name2', $nick_name); */

        //查
     /*   $rs = Db::create()->query('SELECT * FROM `mall_user`  WHERE  id = "1"')->fetchAll();

        $this->set('dsat123112333333333a', $rs);*/
        

//        $data = Db::create()->getEntityManager()
//            ->createQuery('select u from ' . User::class . ' u where u.id = 1')
//            ->getResult();
     /*   //查
        $data = User::getRepository()->findBy(['id' => 1, 'nickName' => 'yuqi']);
        $list = [];

        /** @var User $item */
      /*  foreach ($data as $item) {
//            $this->set('1111', ($item));
            $list[] = $item->getNickName();
        }
        $this->set('data222', $list);
        $this->set('auth', User::getInstance(1)->getAuth()); */

    }

}