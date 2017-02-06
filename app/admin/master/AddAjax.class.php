<?php
/**
 * Created by PhpStorm.
 * User: baofan
 * Date: 2016/11/7
 * Time: 16:27
 */

namespace Sdxapp\Admin\Ajax\Master;

use Sdxapp\Admin\AdminMaster;
use Sdxapp\Api\AdminApi;
use Sdxapp\AppException;

class AddAjax extends AdminApi
{
    protected $email;
    protected $phone;
    protected $user_face;
    protected $user_name;
    protected $nick_name;
    protected $password;
    protected $definition = [
        'email'     => [self::TYPE_STRING, self::FIELD_REQUIRE],
        'phone'     => [self::TYPE_STRING, self::FIELD_REQUIRE],
        'user_face' => [self::TYPE_STRING, self::FIELD_REQUIRE],
        'user_name' => [self::TYPE_STRING, self::FIELD_REQUIRE],
        'nick_name' => [self::TYPE_STRING, self::FIELD_REQUIRE],
        'password'  => [self::TYPE_STRING, self::FIELD_REQUIRE],
    ];

    public function run()
    {
        if (!preg_match('/^1[1-9]\d{9}$/', $this->phone)) {
            throw new AppException(['手机号码不合法', 'Phone is illegal']);
        }
        if (!preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/', $this->email)) {
            throw new AppException(['邮箱不合法', 'email is illegal']);
        }

        //判断用户是否存在
        AdminMaster::checkUserExist($this->user_name, $this->phone, $this->email);

        $salt = AdminMaster::makeSalt();

        AdminMaster::insert(
            [
                'email'     => $this->email,
                'phone'     => $this->phone,
                'user_face' => $this->user_face,
                'user_name' => $this->user_name,
                'nick_name' => $this->nick_name,
                'password'  => AdminMaster::encodePwd($this->password, $salt),
                'salt'      => $salt,
                'is_lock'   => 0,
            ]
        );

        $this->success();
    }
}