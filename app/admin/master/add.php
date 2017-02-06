<?php
/**
 * Created by PhpStorm.
 * User: baofan
 * Date: 2016/11/7
 * Time: 16:27
 */
namespace app\admin\master;

use app\AdminApi;
use Doctrine\ORM\Cache;
use mmapi\core\AppException;
use mmapi\core\Validate;
use model\entity\AdminMaster;
use model\entity\AdminMasterGroup;

class add extends AdminApi
{
    protected $email;
    protected $phone;
    protected $user_face;
    protected $user_name;
    protected $nick_name;
    protected $password;
    protected $group_id;
    protected $id;
    protected $is_lock;

    protected function init()
    {
        $this->addParam('id')->setRequire(false)->setType(self::TYPE_INT);
        $this->addParam('email')->setRequire('邮箱不可为空~')->setType(self::TYPE_STRING);
        $this->addParam('phone')
            ->setRequire('手机号不可为空~')
            ->setValidate("isPhone")
            ->setValidateException('手机验证不合法');

        $this->addParam('user_name')->setRequire('用户名称不可为空~')->setType(self::TYPE_STRING);
        $this->addParam('nick_name')->setRequire('用户昵称不可为空~')->setType(self::TYPE_STRING);

        $this->addParam('password')->setRequire(false);
        $this->addParam('user_face')->setRequire('用户头像不可为空~');
        $this->addParam('group_id')->setRequire('分组不可为空~');
        $this->addParam('is_lock')->setRequire(false)->setDefault(0);
    }

    /**
     * run
     * @author yuqi
     * @throws AppException
     */
    public function run()
    {
        if (!preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/', $this->email)) {
            throw new AppException(['邮箱不合法', 'email is illegal']);
        }

        //判断用户是否存在
        if ($this->id) {
            /** @var AdminMaster $adminMasterObj */
            $adminMasterObj = AdminMaster::getInstance($this->id);
            if (is_null($adminMasterObj)) {
                throw new AppException("该管理员不存在", '171113');
            }
        } else {
            $adminMasterObj = new AdminMaster();
            if(!$this->password){
                throw new AppException("请输入密码~", "PASSWORD");
            }
        }
        /** @var AdminMasterGroup $groupObj */
        $groupObj = AdminMasterGroup::getInstance($this->group_id);

        $adminMasterObj
            ->setEmail($this->email)
            ->setGroup($groupObj)
            ->setPhone($this->phone)
            ->setUserName($this->user_name)
            ->setUserFace($this->user_face)
            ->setIsLock($this->is_lock)
            ->setNickName($this->nick_name);
        if ($this->password) {
            $salt = $adminMasterObj->createSalt();
            $adminMasterObj
                ->setPassword(AdminMaster::encodePasswd($this->password, $salt))
                ->setSalt($salt);
        }
        $adminMasterObj->save();
    }
}