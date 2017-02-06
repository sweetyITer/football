<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/17
 * Time: 18:16
 */

namespace model\entity;

use mmapi\core\Log;
use mmapi\core\Model;
use mmapi\core\Db;
use mmapi\core\AppException;

class MallGoodsComment extends Model
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
     * @var int
     */
    protected $userId;

    /**
     * @var int
     */
    protected $goodsId;

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
     *
     * setGoodsId @desc
     *
     * @author wangjuan
     *
     * @param $goodsId
     *
     * @return $this
     *
     */
    public function setGoodsId($goodsId)
    {
        $this->goodsId = $goodsId;

        return $this;
    }

    /**
     * Get post
     *
     * @return \model\entity\News
     */
    public function getGoodsId()
    {
        return $this->goodsId;
    }

    /**
     * getList @desc 获取商品评论
     *
     * @author wangjuan
     *
     * @param Goods $goodsObj 商品对象
     * @param int   $page     页数
     * @param   int $size     每页显示行数
     * @param User  $user     用户对象
     *
     * @return array
     */
    static public function getList(Goods $goodsObj, $page, $size, User $user)
    {
        $commentData = Db::create()->sqlBuilder()
            ->select()
            ->from('mall_goods_comment')
            ->where('goods_id')
            ->eq($goodsObj->getId())
            ->limit(($page - 1) * $size, $size)
            ->order('up_count desc')
            ->fetchAll();

        $commentList = [];
        foreach ($commentData as $v) {

            /** @var User $authorObj */
            $authorObj = User::getInstance($v['user_id']);

            /** @var MallGoodsComment $mallGoodsCommentObj */
            $mallGoodsCommentObj = MallGoodsComment::getInstance($v['id']);
            $commentList[]       = [
                'id'       => $v['id'],
                'author'   => $authorObj->getUserName(),
                'face_img' => $authorObj->getFaceImg(),
                'content'  => $v['content'],
                'up_count' => $v['up_count'],
                'add_time' => $v['add_time'],
                'is_up'    => $user ? $mallGoodsCommentObj->isCommentUp($user) : false,
            ];
        }

        return $commentList;
    }

    /**
     *
     * getFaceImgs @desc  获取商品评论者头像
     *
     * @author wangjuan
     *
     * @param Goods $goodsObj
     * @param   int $page 页数
     * @param   int $size 每页显示数量
     *
     * @return array
     *
     */
    static public function getFaceImgs(Goods $goodsObj, $page, $size)
    {
        $Data = Db::create()->sqlBuilder()
            ->select('user_id')
            ->from('mall_goods_comment')
            ->where('goods_id')
            ->eq($goodsObj->getId())
            ->limit(($page - 1) * $size, $size)
            ->order('up_count desc')
            ->fetchAll();

        $face_imgs = [];
        foreach ($Data as $v) {
            /** @var User $authorObj */
            $authorObj = User::getInstance($v['user_id']);
            array_push($face_imgs, $authorObj->getFaceImg());
            $face_imgs = array_unique($face_imgs);
        }
     
        return $face_imgs;
    }

    /**
     * isCommentUp @desc 判断当前用户是否对该评论点赞
     *
     * @author wangjuan
     *
     * @param User $user 用户对象
     *
     * @return bool
     */
    public function isCommentUp(User $user)
    {
        return Db::create()
            ->sqlBuilder()
            ->select('comment_id')
            ->from('mall_goods_comment_up')
            ->where('comment_id')->eq($this->id)
            ->andWhere('user_id')->eq($user->getId())
            ->getField('comment_id') == $this->id;
    }

    /**
     * setCommentUp @desc 设置用户对评论点赞
     *
     * @author wangjuan
     *
     * @param User $user 用户id
     */
    public function setCommentUp(User $user)
    {
        $rs = Db::create()->sqlBuilder()
            ->replace('mall_goods_comment_up')
            ->set('user_id')
            ->value($user->getId())
            ->set('comment_id')
            ->value($this->id)
            ->exec();
        if ($rs === 1) {
            /** @var MallGoodsComment $mallGoodsCommentObj */
            $mallGoodsCommentObj = MallGoodsComment::getInstance($this->getId());
            $mallGoodsCommentObj->setUpCount((int)$mallGoodsCommentObj->getUpCount() + 1)->save();
        }

    }

}