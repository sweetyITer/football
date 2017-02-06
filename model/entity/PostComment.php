<?php

namespace model\entity;

use mmapi\core\Log;
use mmapi\core\Model;
use mmapi\core\Db;
use mmapi\core\AppException;

/**
 * PostComment
 */
class PostComment extends Model
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

    /**
     * @var \model\entity\User
     */
    private $user;

    /**
     * @var \model\entity\Post
     */
    private $post;

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
     * Set upCount
     *
     * @param integer $upCount
     *
     * @return PostComment
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
     * Set user
     *
     * @param \model\entity\User $user
     *
     * @return PostComment
     */
    public function setUser(\model\entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \model\entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set post
     *
     * @param \model\entity\Post $post
     *
     * @return PostComment
     */
    public function setPost(\model\entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \model\entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     *
     * isCommentUp @desc 当前用户是否对该评论点赞
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
            ->from('post_comment_up')
            ->where('comment_id')->eq($this->getId())
            ->andWhere('user_id')->eq($currentUser->getId())
            ->getField('comment_id') == $this->getId();
    }

    /**
     *
     * setCommentUp @desc  设置当前用于对帖子评论点赞
     *
     * @author wangjuan
     *
     * @param User $user 用户对象
     */
    public function setCommentUp(User $user)
    {
        Db::create()->sqlBuilder()
            ->insert('post_comment_up')
            ->set('comment_id')->expValue($this->getId())
            ->set('user_id')->expValue($user->getId())
            ->exec();
    }

    /**
     * setCommentUnup @desc 取消评论的点赞
     *
     * @author wangjuan
     */
    public function setCommentUnup()
    {
        Db::create()->sqlBuilder()
            ->delete('post_comment_up')
            ->where('comment_id')->eq($this->getId())
            ->where('user_id')->eq($this->user->getId())
            ->exec();
    }
    
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
     *
     * getCommentList @desc 获取帖子对应评论列表
     *
     * @author wangjuan
     *
     * @param Post $postObj     帖子对象
     * @param int  $pageNo      当前页数
     * @param User $currentUser 当前用户对象
     *
     * @return array
     */
    static public function getCommentList(Post $postObj, $pageNo, User $currentUser)
    {
        //评论内容
        $commentData = Db::create()->sqlBuilder()
            ->select()
            ->from('post_comment')
            ->where('post_id')
            ->eq($postObj->getId())
            ->limit(($pageNo - 1) * self::COMMENT_LIST_SIZE, self::COMMENT_LIST_SIZE)
            ->order('up_count desc')
            ->fetchAll();

        $commentList = [];
        foreach ($commentData as $v) {
            /** @var User $authorObj */
            $authorObj = User::getInstance($v['user_id']);
            /** @var PostComment $postCommentObj */
            $postCommentObj = PostComment::getInstance($v['id']);
            $commentList[]  = [
                'id'       => $v['id'],
                'author'   => $authorObj->getUserName(),
                'face_img' => $authorObj->getFaceImg(),
                'content'  => $v['content'],
                'up_count' => $v['up_count'],
                'add_time' => $v['add_time'],
                'is_up'    => $currentUser ? $postCommentObj->isCommentUp($currentUser) : false,
            ];
        }

        return $commentList;
    }

    /**
     *
     * getFaceImgs @desc  获取评论者头像
     *
     * @author wangjuan
     *
     * @param Post $postObj 帖子对象
     * @param  int $page    页数
     *
     * @return array
     */
    static public function getFaceImgs(Post $postObj, $page)
    {
        //评论内容
        $Data = Db::create()->sqlBuilder()
            ->select('user_id')
            ->from('post_comment')
            ->where('post_id')
            ->eq($postObj->getId())
            ->limit(($page - 1) * self::COMMENT_LIST_SIZE, self::COMMENT_LIST_SIZE)
            ->order('up_count desc')
            ->fetchAll();

        $face_imgs = [];
        foreach ($Data as $v) {
            /** @var User $authorObj */
            $authorObj = User::getInstance($v['user_id']);
            array_push($face_imgs, $authorObj->getFaceImg());
            $face_imgs = array_unique($face_imgs);
        }

        return array_values($face_imgs);
    }

    /**
     * getComment @desc 获取帖子评论
     *
     * @author wangjuan
     *
     * @param int $post_id 帖子id
     * @param int $page    页数
     * @param int $size    每页显示行数
     *
     * @return array
     */
    static public function getComment($post_id, $page, $size)
    {
        return Db::create()->sqlBuilder()
            ->select('u.user_name, p.content')
            ->from('post_comment', 'p')
            ->join('mall_user', 'u')
            ->on('p.user_id', 'u.id')
            ->where('p.post_id')->eq($post_id)
            ->limit(($page - 1) * $size, $size)
            ->order('add_time desc')
            ->fetchAll();
    }
}

