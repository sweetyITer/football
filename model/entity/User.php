<?php

namespace model\entity;

use library\extend\Aes;
use mmapi\api\ApiException;
use mmapi\core\AppException;
use mmapi\core\Db;
use mmapi\core\Log;
use model\footballModel;

/**
 * User
 */
class User extends footballModel
{
    const SECRET = 'd4e5d903d4c0ee91';
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $nickName;

    /**
     * @var string
     */
    private $faceImg = '';

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var string
     */
    private $sex = 'unkonw';

    /**
     * @var string
     */
    private $money = '0.00';

    /**
     * @var integer
     */
    private $addressId = '0';

    /**
     * @var string
     */
    private $regTime = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    private $lastLogin = '0000-00-00 00:00:00';

    /**
     * @var string
     */
    private $updateTime;

    /**
     * @var string
     */
    private $lastIp;

    /**
     * @var integer
     */
    private $loginCount = '0';

    /**
     * @var string
     */
    private $salt;

    /**
     * @var integer
     */
    private $parentId = '0';

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $guid;

    /**
     * @var boolean
     */
    private $isLock = '0';

    /**
     * @var string
     */
    private $userFrom = '';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $goods;

    /**
     * @var string 用户加密后的凭证
     */
    private $auth;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->goods = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return User
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set nickName
     *
     * @param string $nickName
     *
     * @return User
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;

        return $this;
    }

    /**
     * Get nickName
     *
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * Set faceImg
     *
     * @param string $faceImg
     *
     * @return User
     */
    public function setFaceImg($faceImg)
    {
        $this->faceImg = $faceImg;

        return $this;
    }

    /**
     * Get faceImg
     *
     * @return string
     */
    public function getFaceImg()
    {
        return $this->faceImg;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password, $salt = '')
    {
        if ($salt == '') {
            $salt = self::createSalt();
        }
        $this->salt     = $salt;
        $this->password = $this->encodePassword($password, $salt);

        return $this;
    }

    /**
     * @desc   createSalt
     * @author chenmingming
     * @return string
     */
    private function createSalt()
    {
        $str  = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $salt = '';
        for ($i = 0; $i <= 5; $i++) {
            $salt .= $str[mt_rand(0, 35)];
        }

        return $salt;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set sex
     *
     * @param string $sex
     *
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set money
     *
     * @param string $money
     *
     * @return User
     */
    public function setMoney($money)
    {
        $this->money = $money;

        return $this;
    }

    /**
     * Get money
     *
     * @return string
     */
    public function getMoney()
    {
        return $this->money;
    }

    /**
     * Set addressId
     *
     * @param integer $addressId
     *
     * @return User
     */
    public function setAddressId($addressId)
    {
        $this->addressId = $addressId;

        return $this;
    }

    /**
     * Get addressId
     *
     * @return integer
     */
    public function getAddressId()
    {
        return $this->addressId;
    }

    /**
     * Set regTime
     *
     * @param string $regTime
     *
     * @return User
     */
    public function setRegTime($regTime)
    {
        $this->regTime = $regTime;

        return $this;
    }

    /**
     * Get regTime
     *
     * @return string
     */
    public function getRegTime()
    {
        return $this->regTime;
    }

    /**
     * Set lastLogin
     *
     * @param string $lastLogin
     *
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return string
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set updateTime
     *
     * @param string $updateTime
     *
     * @return User
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set lastIp
     *
     * @param string $lastIp
     *
     * @return User
     */
    public function setLastIp($lastIp)
    {
        $this->lastIp = $lastIp;

        return $this;
    }

    /**
     * Get lastIp
     *
     * @return string
     */
    public function getLastIp()
    {
        return $this->lastIp;
    }

    /**
     * Set loginCount
     *
     * @param integer $loginCount
     *
     * @return User
     */
    public function setLoginCount($loginCount)
    {
        $this->loginCount = $loginCount;

        return $this;
    }

    /**
     * Get loginCount
     *
     * @return integer
     */
    public function getLoginCount()
    {
        return $this->loginCount;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return User
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        if (preg_match('/^1[0-9]{10}$/', $phone)) {
            $this->phone = $phone;
        }

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set guid
     *
     * @param string $guid
     *
     * @return User
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;

        return $this;
    }

    /**
     * Get guid
     *
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * Set status
     *
     * @param boolean $isLock
     *
     * @return User
     */
    public function setIsLock($isLock)
    {
        $this->isLock = $isLock == true;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function isLock()
    {
        return $this->isLock === true;
    }

    /**
     * Set userFrom
     *
     * @param string $userFrom
     *
     * @return User
     */
    public function setUserFrom($userFrom)
    {
        $this->userFrom = $userFrom;

        return $this;
    }

    /**
     * Get userFrom
     *
     * @return string
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add good
     *
     * @param \model\entity\Goods $good
     *
     * @return User
     */
    public function addGood(\model\entity\Goods $good)
    {
        $this->goods[] = $good;

        return $this;
    }

    /**
     * Remove good
     *
     * @param \model\entity\Goods $good
     */
    public function removeGood(\model\entity\Goods $good)
    {
        $this->goods->removeElement($good);
    }

    /**
     * Get goods
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGoods()
    {
        return $this->goods;
    }

    /**
     * @desc   getAuth
     * @author chenmingming
     * @return string
     */
    public function getAuth()
    {
        if (is_null($this->auth)) {
            $this->setAuth();
        }

        return $this->auth;
    }

    /**
     * @desc   setAuth
     * @author chenmingming
     */
    protected function setAuth()
    {
        $this->auth = Aes::encrypt(
            implode("\t", [$this->id, $this->guid]),
            self::SECRET
        );
    }

    /**
     * @desc   getInstanceByAuth
     * @author chenmingming
     *
     * @param string $auth 用户凭证
     *
     * @return User 用户对象
     *
     * @throws AppException
     */
    static public function getInstanceByAuth($auth)
    {
        $encryptStr = Aes::decrypt($auth, self::SECRET);
        if (!$encryptStr) {
            throw new AppException('用户不存在或登录已经过期', 'USER_NOT_FUND', 'invalid auth');
        }
        list($id, $guid) = explode("\t", $encryptStr);
        /** @var User $user */
        $user = User::getInstance($id);
        if (!$user) {
            throw new AppException('用户不存在或登录已经过期', 'USER_NOT_FUND', 'invalid uid');
        }
        if ($user->getGuid() != $guid) {
            throw new AppException('用户不存在或登录已经过期', 'USER_NOT_FUND', 'guid invalid');
        }

        return $user;
    }

    /**
     * encodePassword 加密密码
     *
     * @author suijing
     *
     * @param string $password 待加密密码
     * @param string $salt     盐值
     *
     * @return string
     */
    private function encodePassword($password, $salt)
    {
        return md5(md5($password) . md5($salt));
    }

    /**
     * @desc   checkPassword
     * @author chenmingming
     *
     * @param string $password 待验证的密码
     *
     * @return bool
     */
    public function checkPassword($password)
    {
        return $this->password == $this->encodePassword($password, $this->salt);
    }

    /**
     * checkUserPhone @desc
     *
     * @author wangjuan
     *
     * @param $phone
     *
     * @return bool
     */
    public function checkUserPhone($phone)
    {
        return $this->phone == $phone;
    }

    /**
     * getIdByUsername @desc
     *
     * @author wangjuan
     *
     * @param $username
     *
     * @return int
     */
    static public function getIdByPhone($username)
    {
        return (int)Db::create()
            ->sqlBuilder()
            ->select('id')
            ->from('mall_user')
            ->where('phone')
            ->eq($username)
            ->getField('id');
    }

    /**
     * nameRepeat @desc
     *
     * @author zhuleifeng
     *
     * @param $name
     *
     * @return array
     */
    public function checkNameRepeat($name)
    {
        return Db::create()->sqlBuilder()
            ->select('user_name')
            ->from('mall_user')
            ->where('user_name')
            ->eq($name)
            ->fetchAll();
    }

    /**
     * regByQQ @desc 第三方登录 QQ
     *
     * @author wangjuan
     *
     * @param $auth_data_array
     *
     * @return int
     * @throws ApiException
     * @throws AppException
     */
    static public function regByQQ($auth_data_array)
    {
        if (empty($auth_data_array['open_id']) || empty($auth_data_array['nick_name']) || empty($auth_data_array['user_face'])) {
            throw new ApiException("QQ登录参数缺失~", "QQ_PARAMS_LOST");
        }
        $user_name = '|QQ|:' . $auth_data_array['open_id'];
        $nickname  = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $auth_data_array['nick_name']);

        //如果没有昵称
        if (empty($nickname)) {
            $nickname = 'QQ用户';
        }

        return self::_reg($user_name, null, $nickname, $auth_data_array['user_face'], 'qq');
    }

    /**
     * regByWeiXin @desc 第三方登陆(微信)
     *
     * @author wangjuan
     *
     * @param $auth_data_array
     *
     * @return int
     * @throws ApiException
     * @throws AppException
     */
    static public function regByWeiXin($auth_data_array)
    {
        if (empty($auth_data_array['open_id']) || empty($auth_data_array['nick_name']) || empty($auth_data_array['user_face'])) {
            throw new ApiException("微信登录参数缺失~", "WEIXIN_PARAMS_LOST");
        }
        $user_name = '|WEIXIN|:' . $auth_data_array['open_id'];
        $nickname  = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $auth_data_array['nick_name']);

        //如果没有昵称
        if (empty($nickname)) {
            $nickname = '微信用户';
        }

        return self::_reg($user_name, null, $nickname, $auth_data_array['user_face'], 'weixin');
    }

    /**
     * regByWeiBo @desc 第三方登录(微博)
     *
     * @author wangjuan
     *
     * @param $auth_data_array
     *
     * @return int
     * @throws ApiException
     * @throws AppException
     */
    static public function regByWeiBo($auth_data_array)
    {
        if (!$auth_data_array['user_id'] || !$auth_data_array['source'] || !$auth_data_array['token'] || !$auth_data_array['user_id']) {
            throw new AppException("微博登录数据缺失", "WEIBO_PARAMS_LOST");
        }

        $user_name         = '|WEIBO|:' . $auth_data_array['user_id'];
        $weibo_request_url = "https://api.weibo.com/2/users/show.json?";
        $param             = [
            'source'       => $auth_data_array['source'],
            'access_token' => $auth_data_array['token'],
            'uid'          => $auth_data_array['user_id'],
        ];
        $weibo_request_url .= http_build_query($param);
        $json_data = self::curl($weibo_request_url);

        if (empty($json_data)) {
            throw new ApiException('请求新浪微博接口数据失败~', "REQUEST_FAILED");
        }
        $user_data = json_decode($json_data, true);

        if ($user_data['error_code']) {
            throw new ApiException('请求新浪微博接口数据失败,' . $user_data['error_code'], "REQUEST_FAILED");

        }
        $nickname = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $user_data['name']);

        return self::_reg($user_name, null, $nickname, $user_data['avatar_hd'], 'weibo');
    }

    static private function curl($url, $post_data = null, $config = [], &$chinfo = [])
    {
        settype($config, 'array');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_ENCODING, true);
        if ($post_data) {
            //一定需要编码,否则接收方会错误
            if (isset($config['upload-file']) && $config['upload-file']) {
                unset($config['upload-file']);
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
            }

        }
        $CURLOPT_HTTPHEADER = [
            'Accept-Encoding:gzip,deflate,sdch',
            'User-Agent:Mozilla/5.0 (Windows NT 5.1; rv:2.0) Gecko/20100101 Firefox/4.0',
            "Referer:{$url}",
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $CURLOPT_HTTPHEADER);
        foreach ($config as $k => $v) {
            if (is_numeric($k)) {
                @curl_setopt($ch, $k, $v);
            }

        }

        $curl_data            = curl_exec($ch);
        $curl_error           = curl_error($ch);
        $chinfo               = curl_getinfo($ch);
        $chinfo['curl_error'] = $curl_error;
        curl_close($ch);
        //如果是跳转
        if ($config['not301'] != 1 && in_array($chinfo['http_code'], ['301', '302']) && $chinfo['redirect_url']) {
            //防止死循环重定向
            $config['not301'] = 1;
            $curl_data        = self::curl($chinfo['redirect_url'], $post_data, $config);
        }

        return $curl_data;
    }

    /**
     * _reg @desc 根据第三方用户信息注册用户并且返回uid
     *
     * @author wangjuan
     *
     * @param string $user_name 用户名
     * @param string $phone     电话号码
     * @param string $nick_name 昵称
     * @param string $user_face 用户头像
     * @param string $user_from 用户来源
     *
     * @return int
     * @throws ApiException
     * @throws AppException
     */
    static private function _reg($user_name, $phone, $nick_name, $user_face, $user_from = '')
    {
        if (empty($user_name)) {
            throw new ApiException("用户名称不能为空", "USER_NAME_EMPTY");
        }
        if (preg_match('/[\x{10000}-\x{10FFFF}]/u', $nick_name)) {
            throw new AppException('昵称不能包含表情等特殊字符~', "NICK_NAME_UNVALID");
        }

        if (!is_null($phone) && !preg_match('/^1[0-9]{10}$/', $phone)) {
            throw new AppException('手机号码不合法~', "PHONE_UNVALID");
        }

        if ($user_from) {
            //如果第三方登陆过
            $uid = self::getUidByUserName($user_name);
            if ($uid > 0) {
                return $uid;
            }
        } else {
            //如果第三方没有登陆，但是用户名称已经存在
            if (self::IsUserNameExist($user_name)) {
                throw new AppException('用户名已经存在，请刷新后再试', "USERNAME_EXITED");
            }
        }

        /** @var User $userObj */
        $userObj = new User();
        $userObj->setGuid("1234")
            ->setLastIp("1")
            ->setPhone($phone == '' ? '' : $phone)
            ->setPassword('')
            ->setNickName($nick_name)
            ->setUserName($user_name)
            ->setEmail('')
            ->setFaceImg($user_face)
            ->setUserFrom($user_from)
            ->save();

        return (int)$userObj->getId();
    }

    /**
     * getUidByUserName @desc 通过用户名称获取id
     *
     * @author wangjuan
     *
     * @param string $user_name
     *
     * @return int
     */
    static private function getUidByUserName($user_name)
    {
        return (int)Db::create()->sqlBuilder()
            ->select('id')
            ->from('mall_user')
            ->where('user_name')
            ->eq($user_name)
            ->getField('id');
    }

    /**
     * IsUserNameExist @desc 检测用户名是否存在
     *
     * @author wangjuan
     *
     * @param string $user_name 用户名
     *
     * @return bool
     */
    static private function IsUserNameExist($user_name)
    {
        return (int)Db::create()->sqlBuilder()
            ->select('count(*) as count')
            ->from('mall_user')
            ->where('user_name')
            ->eq($user_name)
            ->getField('count') > 0;
    }

    /**
     * loginOut @desc 退出登录
     *
     * @author wangjuan
     */
    static public function loginOut()
    {
        setcookie('uid', 1, time() - 3600, '/');
        setcookie('auth', 1, time() - 3600, '/');
    }

    /**
     * IsPhoneExit @desc 检测电话号码是否已经注册
     * @author wangjuan
     * @param string $phone 电话号码
     *
     * @return bool
     */
    static public function IsPhoneExit($phone)
    {
        return (int) Db::create()->sqlBuilder()
            ->select('phone')
            ->from('mall_user')
            ->where('phone')->eq($phone)
            ->getField('phone') == $phone;
    }

}

