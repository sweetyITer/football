<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2017/1/9
 * Time: 11:20
 */

namespace model\repository;

use Doctrine\ORM\EntityRepository;
use mmapi\core\Db;
use mmapi\core\Log;
use model\entity\Post;
use model\entity\Quan;
use model\entity\User;
use model\entity\News;

class UserRepos extends EntityRepository
{

    /**
     * upPost @desc 点赞帖子
     *
     * @author wangjuan
     *
     * @param User $user    用户对象
     * @param Post $postObj 帖子对象
     *
     * @return bool
     */
    public function upPost(User $user, Post $postObj)
    {
        $rs = Db::create()->sqlBuilder()
            ->replace('post_up')
            ->set('user_id')->value($user->getId())
            ->set('post_id')->value($postObj->getId())
            ->exec();
        if ($rs === 1) {
            $postObj->setUpCount((int)$postObj->getUpCount() + 1)->save();
        }
    }

    /**
     * isPostUp @desc
     *
     * @author wangjuan
     *
     * @param User $user 用户id
     * @param Post $post 帖子对象
     *
     * @return bool
     */
    public function isPostUp(User $user, Post $post)
    {
        return Db::create()->sqlBuilder()
            ->select('post_id')
            ->from('post_up')
            ->where('post_id')->eq($post->getId())
            ->where('user_id')->eq($user->getId())
            ->getField('post_id') == $post->getId();
    }

    /**
     * isPostCollect @desc 判断帖子是否已经收藏
     *
     * @author wangjuan
     *
     * @param User $user 用户对象
     * @param Post $post 帖子对象
     *
     * @return bool
     */
    public function isPostCollect(User $user, Post $post)
    {
        return Db::create()->sqlBuilder()
            ->select('post_id')
            ->from('post_collect')
            ->where('post_id')->eq($post->getId())
            ->where('user_id')->eq($user->getId())
            ->getField('post_id') == $post->getId();
    }

    /**
     * setCollect @desc  设置
     *
     * @author wangjuan
     *
     * @param User $user
     * @param Post $postObj
     */
    public function setCollect(User $user, Post $postObj)
    {
        $rs = Db::create()->sqlBuilder()
            ->replace('post_collect')
            ->set('user_id')->value($user->getId())
            ->set('post_id')->value($postObj->getId())
            ->exec();

        if ($rs === 1) {
            //post表collect数 + 1
            Db::create()->sqlBuilder()
                ->update('post')
                ->set('collect_count')
                ->value((int)$postObj->getCollectCount() + 1)
                ->where('id')
                ->eq($postObj->getId())
                ->exec();
        }
    }

    /**
     * setUnCollect @desc 取消收藏
     *
     * @author wangjuan
     *
     * @param User $user    用户对象
     * @param Post $postObj 帖子对象
     */
    public function setUnCollect(User $user, Post $postObj)
    {
        $rs = Db::create()->sqlBuilder()
            ->delete('post_collect')
            ->where('post_id')->eq($postObj->getId())
            ->where('user_id')->eq($user->getId())
            ->exec();

        if ($rs === 1) {
            //post表collect数 - 1
            Db::create()->sqlBuilder()
                ->update('post')
                ->set('collect_count')
                ->value((int)$postObj->getCollectCount() - 1)
                ->where('id')
                ->eq($postObj->getId())
                ->exec();
        }

    }

    /**
     * postCollect @desc 收藏帖子
     *
     * @author wangjuan
     *
     * @param User $user
     * @param Post $postObj
     *
     * @return bool
     */
    public function postCollect(User $user, Post $postObj)
    {
        if ($this->isPostCollect($user, $postObj)) {
            $this->setUnCollect($user, $postObj);

            return false;
        } else {
            $this->setCollect($user, $postObj);

            return true;
        }
    }

    /**
     * setfollowQuan @desc
     *
     * @author wangjuan
     *
     * @param User $user
     * @param Quan $quanObj
     */
    public function setfollow(User $user, Quan $quanObj)
    {
        Db::create()->sqlBuilder()
            ->replace('quan_user')
            ->set('quan_id')->value($quanObj->getId())
            ->set('user_id')->value($user->getId())
            ->exec();
    }

    /**
     * setUnfollowQuan @desc 取消关注圈子
     *
     * @author wangjuan
     *
     * @param User $user
     * @param Quan $quanObj
     */
    public function setUnfollow(User $user, Quan $quanObj)
    {
        Db::create()->sqlBuilder()
            ->delete('quan_user')
            ->where('quan_id')->eq($quanObj->getId())
            ->where('user_id')->eq($user->getId())
            ->exec();
    }

    /**
     * isFollowQuan @desc 是否关注圈子
     *
     * @author wangjuan
     *
     * @param User $user    用户对象
     * @param Quan $quanObj 圈子对象
     *
     * @return bool
     */
    public function isFollowQuan(User $user, Quan $quanObj)
    {
        return Db::create()->sqlBuilder()
            ->select('quan_id')
            ->from('quan_user')
            ->where('quan_id')->eq($quanObj->getId())
            ->where('user_id')->eq($user->getId())
            ->getField('quan_id') == $quanObj->getId();
    }

    /**
     * followQuan @desc  关注/取消关注圈子
     *
     * @author wangjuan
     *
     * @param User $user    用户对象
     * @param Quan $quanObj 圈子对象
     *
     * @return bool
     */
    public function followQuan(User $user, Quan $quanObj)
    {
        //取消关注
        if ($this->isFollowQuan($user, $quanObj)) {
            $this->setUnfollow($user, $quanObj);

            return false;
        } else {
            $this->setfollow($user, $quanObj);

            return true;
        }
    }

    /**
     *
     * myFollowQuan @desc 我关注帖子的列表
     *
     * @author wangjuan
     *
     * @param User $user
     *
     * @return array
     */
    public function myFollowQuanList(User $user)
    {
        return Db::create()->sqlBuilder()
            ->select('q.title, q.icon')
            ->from('quan_user', 'qu')
            ->join('quan', 'q')
            ->on('qu.quan_id', 'q.id')
            ->where('qu.user_id')->eq($user->getId())
            ->fetchAll();
    }

    /**
     * myFollowQuanCount @desc
     *
     * @author wangjuan
     *
     * @param User $user
     *
     * @return int
     */
    public function myFollowQuanCount(User $user)
    {
        return (int)Db::create()->sqlBuilder()
            ->select('count(*) as count')
            ->from('quan_user', 'qu')
            ->join('quan', 'q')
            ->on('qu.quan_id', 'q.id')
            ->where('qu.user_id')->eq($user->getId())
            ->getField('count');

    }

    /**
     * isNewsCollect @desc 判断用户是否收藏
     *
     * @author wangjuan
     *
     * @param User $user   用户对象
     * @param News $newObj 新闻对象
     *
     * @return bool
     */
    public function isNewsCollect(User $user, News $newObj)
    {
        return Db::create()->sqlBuilder()
            ->select('news_id')
            ->from('news_collect')
            ->where('news_id')->eq($newObj->getId())
            ->andWhere('user_id')->eq($user->getId())
            ->getField('news_id') == $newObj->getId();
    }

    /**
     * setNewsCollect @desc 收藏资讯
     *
     * @author wangjuan
     *
     * @param User $user 用户对象
     * @param News $news 资讯对象
     */
    public function setNewsCollect(User $user, News $news)
    {
        $rs = Db::create()->sqlBuilder()
            ->replace('news_collect')
            ->set('user_id')
            ->value($user->getId())
            ->set('news_id')
            ->value($news->getId())
            ->exec();
        if ($rs === 1) {
            $news->setCollectCount((int)$news->getCollectCount() + 1)
                ->save();
        }
    }

    /**
     * setNewsUnCollect @desc 取消收藏
     *
     * @author wangjuan
     *
     * @param User $user 用户对象
     * @param News $news 资讯对象
     */
    public function setNewsUnCollect(User $user, News $news)
    {
        $rs = Db::create()->sqlBuilder()
            ->delete('news_collect')
            ->where('news_id')->eq($news->getId())
            ->where('user_id')->eq($user->getId())
            ->exec();
        if ($rs === 1) {
            $news->setCollectCount(((int)$news->getCollectCount() - 1))
                ->save();
        }

    }

    /**
     * newsCollect @desc 判断咨询收藏（取消收藏）
     *
     * @author wangjuan
     *
     * @param User $user 用户对象那个
     * @param News $news 资讯对象
     *
     * @return bool
     */
    public function newsCollect(User $user, News $news)
    {
        if ($this->isNewsCollect($user, $news)) {
            $this->setNewsUnCollect($user, $news);

            return false;
        } else {
            $this->setNewsCollect($user, $news);

            return true;
        }
    }

    /**
     * isNewsUp @desc  判断用户是否已经对资讯点赞
     *
     * @author wangjuan
     *
     * @param User $user
     * @param News $newObj
     *
     * @return bool
     */
    public function isNewsUp(User $user, News $newObj)
    {
        return Db::create()->sqlBuilder()
            ->select('news_id')
            ->from('news_up')
            ->where('news_id')->eq($newObj->getId())
            ->andWhere('user_id')->eq($user->getId())
            ->getField('news_id') == $newObj->getId();
    }

    /**
     * setNewsUp @desc 咨询点赞
     * @author wangjuan
     * @param User $user 用户id
     * @param News $newObj 咨询对象
     */
    public function setNewsUp(User $user, News $newObj)
    {
        $rs = Db::create()->sqlBuilder()
            ->replace('news_up')
            ->set('user_id')
            ->value($user->getId())
            ->set('news_id')
            ->value($newObj->getId())
            ->exec();
        if ($rs === 1) {
            $newObj->setUpCount((int)$newObj->getUpCount() + 1)->save();
        }
    }

}