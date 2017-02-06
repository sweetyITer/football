<?php
/**
 * Created by PhpStorm.
 * User: suijing
 * Date: 2017/1/4
 * Time: 13:18
 */

namespace app\api\user;

use app\AppApi;
use mmapi\core\AppException;

class editPassword extends AppApi
{
    protected $old_password;
    protected $new_password;

    protected function init()
    {
        $this->addParams(['new_password', 'old_password']);
    }

    /**
     * run desc?
     *
     * @author suijing
     */
    public function run()
    {

        if (!$this->user->checkPassword($this->old_password))
            throw new AppException('原密码不正确'.$this->user->checkPassword($this->old_password), 'OLD PASSWORD ERROR');

        $this->user->setPassword($this->new_password)->save();
    }

}