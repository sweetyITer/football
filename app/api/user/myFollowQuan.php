<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/5
 * Time: 14:37
 */
namespace app\api\user;

use app\AppApi;
use model\entity\User;
use model\repository\UserRepos;

class myFollowQuan extends AppApi
{
    
    protected function init()
    {
        
    }

    /**
     * run @desc 圈子列表
     *
     * @author wangjuan
     */
    public function run()
    {
        /** @var UserRepos $userRepos */
        $userRepos = User::getRepository();
        $list      = $userRepos->myFollowQuanList($this->user);

        $this->set('data', $list);
    }
}
