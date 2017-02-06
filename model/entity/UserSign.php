<?php

namespace model\entity;

use mmapi\api\ApiException;
use mmapi\core\Log;
use mmapi\core\Model;
use mmapi\core\Db;

/**
 * UserSign
 */
class UserSign extends Model
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $signKey;

    /**
     * @var integer
     */
    private $status = 0;

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;

    const DAY_LIMIT_COUNT = 30;

    private $debug = false;

    const USER_NAME = 'shxsdz-1';

    const PASS_WORD = "348dce";

    private $user_name;

    private $password;

    const REQUEST_URL = 'http://si.800617.com:4400/SendLenSms.aspx';

    const SIGN = 'football';

    /**
     * UserSign constructor.
     *
     * @param string $user_name
     * @param string $password
     */
    public function __construct($user_name = '', $password = '')
    {
        $this->addTime = date('Y-m-d H:i:s',time());
        empty($user_name) && $user_name = self::USER_NAME;
        empty($password) && $password = self::PASS_WORD;

        if (empty($user_name) || empty($password)) {
            throw new ApiException('畅天游短信账号，密码不能为空~', 70000);
        }
        $this->user_name = $user_name;
        $this->password  = $password;

    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return UserSign
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return UserSign
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set signKey
     *
     * @param string $signKey
     *
     * @return UserSign
     */
    public function setSignKey($signKey)
    {
        $this->signKey = $signKey;

        return $this;
    }

    /**
     * Get signKey
     *
     * @return string
     */
    public function getSignKey()
    {
        return $this->signKey;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return UserSign
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return UserSign
     */
    public function setAddTime($addTime)
    {
        $this->addTime = $addTime;

        return $this;
    }

    /**
     * Get addTime
     *
     * @return string
     */
    public function getAddTime()
    {
        return $this->addTime;
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

    //获取随机验证码
    private function getRandCode()
    {
        return mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
    }

    /**
     * checkVerify @desc 检测验证码是否正确
     *
     * @author wangjuan
     *
     * @param string $phone      电话号码
     * @param string $code       验证码
     * @param string $type       验证码类型
     * @param int    $valid_time 验证码有效时间
     *
     * @return bool
     * @throws ApiException
     */
    public function checkVerify($phone, $code, $type, $valid_time)
    {
        //查询出最新一条的验证码数据
        $info = Db::create()->sqlBuilder()
            ->select()
            ->from('user_sign')
            ->where('number')
            ->eq($phone)
            ->where('type')
            ->eq($type)
            ->order('add_time desc')
            ->limit(0, 1)
            ->fetch();

        /** @var UserSign $userSignObj */
        $userSignObj = UserSign::getInstance($info['id']);
        if ($info['sign_key'] == $code) {
            if ($userSignObj->getStatus() == 1) {
                throw new ApiException('验证码已经被使用过,请重新发送验证码', "CODE_USED");
            }
            if (empty($valid_time)) {
                $userSignObj->setStatus(1)->save();

                return true;
            } else {
                //如果没有超时，可以验证。
                if (strtotime($userSignObj->getAddTime()) + $valid_time > time()) {
                    $userSignObj->setStatus(1)->save();

                    return true;
                } else {
                    //如果超时，设置验证码已经使用过。
                    $userSignObj->setStatus(1)->save();
                    throw new ApiException('验证码已经失效', 'CODE_UNVALID');
                }
            }

        } else {
            throw new ApiException('验证码错误', 'CODE_ERROR');
        }
    }

    /**
     * sendCode @desc 设置短信内容
     *
     * @author wangjuan
     *
     * @param string $phone 电话号码
     * @param string $type  类型
     *
     * @throws ApiException
     */
    public function sendCode($phone, $type)
    {
        $code    = $this->getRandCode();
        $message = "亲爱的football用户您好，您本次操作的验证码是" . $code . ", 60秒内有效";
        $this->send($phone, $type, $message, 60, $code);
    }

    /**
     * send @desc 检验发送信息频率
     *
     * @author wangjuan
     *
     * @param string $phone
     * @param string $type
     * @param string $message
     * @param int    $during_time 发送验证码的间隔时间
     * @param string $code
     *
     * @throws ApiException
     */
    private function send($phone, $type, $message, $during_time, $code)
    {
        if ($this->getMsgTodayCount($phone, $type) > self::DAY_LIMIT_COUNT) {
            throw new ApiException('超过每天发送短信的限制数量', 'SEND_MORE_THAN_LIMIT');
        }
        if ($this->checkSpace($phone, $type, $during_time)) {
            throw new ApiException('发送太频繁', 'SEND_TOO_MANY');
        }
        $this->sendMessage($phone, $message, self::SIGN, $type, $code);
    }

    /**
     * @desc   检验手机号码是否合法
     * @since  2015-11-16 10:41
     * @author chenchao
     *
     * @param string $phone 手机号码
     *
     * @return int
     */
    private function checkPhoneNum($phone)
    {
        return preg_match('/^1[0-9]{10}$/', $phone);
    }

    /**
     *
     * sendMessage @desc  发送手机验证码
     *
     * @author
     *
     * @param  string   $phone   手机号
     * @param    string $message 信息
     * @param   string  $sign    签名
     * @param string    $type    类型
     *
     * @throws ApiException
     */
    protected function sendMessage($phone, $message, $sign, $type = '', $code)
    {
        if (!$this->checkPhoneNum($phone)) {
            throw new ApiException(['手机号码不合法~' . $phone, 'PHONE_ERROR']);
        }
        $message .= '【' . $sign . '】';

        $gbk_message = iconv('UTF-8', 'GB2312', $message);

        if ($this->debug) {
            $content = 'test';
            $result  = [
                'value' => 1,
            ];
            $sendnum = [
                'value' => 1,
            ];
        } else {
            $param = [
                'un'     => $this->user_name,
                'pwd'    => $this->password,
                'mobile' => $phone,
                'msg'    => $gbk_message,
            ];

            $url = self::REQUEST_URL . "?" . http_build_query($param);

            $content = $this->curl($url);
            if ($content === false) {
                throw new ApiException(['curl请求发送短信失败~', 'REQUEST_ERROR']);
            }
            //解析返回的xml
            $xml = xml_parser_create();
            xml_parse_into_struct($xml, $content, $vals, $index);
            xml_parser_free($xml);
            list(, $result, $sendnum) = $vals;
        }
        if ($result['value'] == 1) {
            $this->recordSign($phone, $type, $code);
        } else {
            throw new ApiException(['发送短信失败~', 'MESSAGE_ERROR']);
        }
    }

    /**
     * recordSign @desc 记录用户发送的验证码
     *
     * @author wangjuan
     *
     * @param string $phone 电话号码
     * @param string $type  类型
     * @param string $code  验证码
     */
    private function recordSign($phone, $type, $code)
    {
        $userSignObj = new UserSign();
        $userSignObj
            ->setType($type)
            ->setNumber($phone)
            ->setSignKey($code)
            ->save();
    }

    /**
     * 请求url
     *
     * @author chenmingming
     *
     * @param string $url 请求url
     *
     * @return bool|mixed
     */
    private function curl($url)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $curl_data  = curl_exec($ch);
        $curl_error = curl_error($ch);
        if ($curl_error) {
            return false;
        }
        curl_close($ch);

        return $curl_data;
    }

    /**
     * getMsgTodayCount @desc 获取今天发送的短信数
     *
     * @author wangjuan
     *
     * @param string $phone 电话
     * @param string $type  类型
     *
     * @return int
     */
    private function getMsgTodayCount($phone, $type)
    {
        return (int)Db::create()->sqlBuilder()
            ->select("count(*) as count")
            ->from('user_sign')
            ->where('date_format(add_time, "%Y-%m-%d")')
            ->eq(date('Y-m-d', time()))
            ->andWhere('number')
            ->eq($phone)
            ->andWhere('type')
            ->eq($type)
            ->getField('count');

    }

    /**
     * checkSpace @desc 检测间隔时间内有没有发送过信息
     *
     * @author wangjuan
     *
     * @param string $phone       手机
     * @param string $type        类型
     * @param int    $during_time 间隔时间（秒）
     *
     * @return bool
     */
    private function checkSpace($phone, $type, $during_time)
    {
        return (int)Db::create()->sqlBuilder()
            ->select("count(*) as count")
            ->from('user_sign')
            ->where('add_time')
            ->gt(date('Y-m-d H:i:s', time() - $during_time))
            ->andWhere('add_time')
            ->lt(date('Y-m-d H:i:s', time()))
            ->andWhere('number')
            ->eq($phone)
            ->andWhere('type')
            ->eq($type)
            ->getField('count') > 0;

    }

}

