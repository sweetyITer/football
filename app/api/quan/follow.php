<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/5
 * Time: 14:38
 */
namespace app\api\quan;

use app\AppApi;
use model\entity\Quan;
use model\entity\User;
use mmapi\core\AppException;
use model\repository\UserRepos;

class follow extends AppApi
{
    protected $quan_id;

    protected function init()
    {
        $this->addParam('quan_id');
    }

    /**
     * run @desc 关注/取消关注
     *
     * @author wangjuan
     */
    public function run()
    {
        /** @var Quan $quanObj */
        $quanObj = Quan::tryInstance($this->quan_id, new AppException('圈子不合法', 'QUAN_INVALID'));

        /** @var UserRepos $userRepos */
        $userRepos = User::getRepository();
        $this->set('status', $userRepos->followQuan($this->user, $quanObj));
    }
}
