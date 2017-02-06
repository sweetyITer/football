<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/13
 * Time: 17:17
 */
namespace model\entity;

use mmapi\core\Log;
use mmapi\core\Model;
use mmapi\core\Db;
use mmapi\core\AppException;

/**
 * PostComment
 */
class NewsComment extends Model
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var integer
     */
    private $upCount = 0;

    /**
     * @var integer
     */
    private $isDelete = 0;

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;

    protected $userId;

    protected $newsId;

    const COMMENT_LIST_SIZE = 5;

    public function __construct()
    {
        $this->addTime = date('Y-m-d H:i:s');
    }

    /**
     * setContent @desc
     *
     * @author wangjuan
     *
     * @param $content
     *
     * @return $this
     * @throws AppException
     */
    public function setContent($content)
    {
        $this->content = $this->filterStr($content);
        if (mb_strlen($this->content) > 140) {
            throw new AppException('帖子内容长度不合法', 'CONTENT_INVALID');
        }
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     *
     * setUpCount @desc
     *
     * @author wangjuan
     *
     * @param $upCount
     *
     * @return $this
     */
    public function setUpCount($upCount)
    {
        $this->upCount = $upCount;

        return $this;
    }

    /**
     * Get upCount
     *
     * @return integer
     */
    public function getUpCount()
    {
        return $this->upCount;
    }

    /**
     * Set isDelete
     *
     * @param mixed $isDelete 是否删除
     *
     * @return PostComment
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete == true ? 1 : 0;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function isDelete()
    {
        return $this->isDelete == 1;
    }

    /**
     *
     * setAddTime @desc 设置评论时间
     *
     * @author wangjuan
     * @return $this
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

    /**
     *
     * setUserId @desc
     *
     * @author wangjuan
     *
     * @param $userId
     *
     * @return $this
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get user
     *
     * @return \model\entity\User
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * setNewsId @desc
     *
     * @author wangjuan
     *
     * @param $newsId
     *
     * @return $this
     */
    public function setNewsId($newsId)
    {
        $this->newsId = $newsId;

        return $this;
    }

    /**
     * Get post
     *
     * @return \model\entity\News
     */
    public function getNewsId()
    {
        return $this->newsId;
    }

    /*  public function setContent($content)
      {
          $this->content = $content;
          return $content;
      }*/

    /**
     * filterStr @desc  过滤
     *
     * @author wangjuan
     *
     * @param $str
     *
     * @return mixed
     */
    public function filterStr($str)
    {
        $str = str_replace('%', '//%', $str);
        $str = str_replace('_', '//_', $str);
        $str = addslashes($str);

        return $str;
    }

    /**
     * getList @desc  获取咨询的评论列表
     *
     * @author wangjuan
     *
     * @param News $newObj      帖子对象
     * @param int  $page        页数
     * @param User $currentUser 当前用户对象
     *
     * @return array
     */
    static public function getList(News $newObj, $page, User $currentUser)
    {
        $commentData = Db::create()->sqlBuilder()
            ->select()
            ->from('news_comment')
            ->where('news_id')
            ->eq($newObj->getId())
            ->limit(($page - 1) * self::COMMENT_LIST_SIZE, self::COMMENT_LIST_SIZE)
            ->order('up_count desc')
            ->fetchAll();
        $commentList = [];
        foreach ($commentData as $v) {
            /** @var User $authorObj */
            $authorObj = User::getInstance($v['user_id']);
            /** @var NewsComment $newsCommentObj */
            $newsCommentObj = NewsComment::getInstance($v['id']);
            $commentList[]  = [
                'id'       => $v['id'],
                'author'   => $authorObj->getUserName(),
                'face_img' => $authorObj->getFaceImg(),
                'content'  => $v['content'],
                'up_count' => $v['up_count'],
                'add_time' => $v['add_time'],
                'is_up'    => $currentUser?$newsCommentObj->isCommentUp($currentUser):false,
            ];

        }

        return $commentList;
    }

    /**
     * getFaceImgs @desc 获取评论者的头像
     *
     * @author wangjuan
     *
     * @param News $newObj 资讯对象
     * @param  int $page   页数
     *
     * @return array
     */
    static public function getFaceImgs(News $newObj, $page)
    {
        $data = Db::create()
            ->sqlBuilder()
            ->select('user_id')
            ->from('news_comment')
            ->where('news_id')
            ->eq($newObj->getId())
            ->limit(($page - 1) * self::COMMENT_LIST_SIZE, self::COMMENT_LIST_SIZE)
            ->order('up_count desc')
            ->fetchAll();
        $imgs = [];
        foreach ($data as $v) {
            /** @var User $userObj */
            $userObj = User::getInstance($v['user_id']);
            array_push($imgs, $userObj->getFaceImg());
        }

        return array_values(array_unique($imgs));
    }

    /**
     * isCommentUp @desc
     *
     * @author wangjuan
     *
     * @param User $currentUser 当前用户对象
     *
     * @return bool
     */
    public function isCommentUp($currentUser)
    {
        return Db::create()->sqlBuilder()
            ->select('comment_id')
            ->from('news_comment_up')
            ->where('comment_id')->eq($this->getId())
            ->andWhere('user_id')->eq($currentUser->getId())
            ->getField('comment_id') == $this->getId();
    }

    /**
     * setCommentUp @desc
     *
     * @author wangjuan
     *
     * @param User $user
     */
    public function setCommentUp(User $user)
    {
        $rs = Db::create()->sqlBuilder()
            ->replace('news_comment_up')
            ->set('user_id')
            ->value($user->getId())
            ->set('comment_id')
            ->value($this->id)
            ->exec();
        if ($rs === 1) {
            /** @var NewsComment $newsCommentObj */
            $newsCommentObj = NewsComment::getInstance($this->getId());
            $newsCommentObj->setUpCount((int)$newsCommentObj->getUpCount() + 1)->save();
        }
    }
}