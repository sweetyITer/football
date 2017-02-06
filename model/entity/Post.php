<?php

namespace model\entity;

use mmapi\core\Log;
use mmapi\core\Model;
use mmapi\core\Db;
use mmapi\core\AppException;
use model\repository\UserRepos;

/**
 * Post
 */
class Post extends Model
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var array 帖子详情数组
     */
    private $contentArray;

    /**
     * @var integer
     */
    private $upCount = 0;

    /**
     * @var integer
     */
    private $collectCount = 0;

    /**
     * @var integer
     */
    private $commentCount = 0;

    /**
     * @var integer
     */
    private $isTop = 0;

    /**
     * @var integer
     */
    private $isIntro = 0;

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
     * @var \model\entity\Quan
     */
    private $quan;

    Const TITLE_LIMIT_LENGTH = 20;

    const COLLECT_SIZE = 3;

    public function __construct()
    {
        $this->addTime = date('Y-m-d H:i:s');
    }

    /**
     *
     * setTitle @desc
     *
     * @author wangjuan
     *
     * @param $title
     *
     * @return $this
     * @throws AppException
     */
    public function setTitle($title)
    {
        $this->title = $this->filterStr($title);
        if (mb_strlen($this->title) > self::TITLE_LIMIT_LENGTH) {
            throw new AppException('帖子标题长度不合法', 'POST_TITLE_VALID');
        }

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {

        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Post
     * @throws AppException
     */
    public function setContent($content = null)
    {

        if ($content) {
            $this->content = $content;
        } elseif (is_null($content) || $this->contentArray) {
            $this->content = json_encode($this->contentArray);
        }

        if (strlen($this->content) > 65535) {
            throw new AppException('帖子内容太长啦', 'CONTENT_TOO_LONG');
        }

        return $this;
    }

    /**
     * @desc   addText 添加帖子详情文字
     * @author chenmingming
     *
     * @param string $text 帖子详情文字
     *
     * @return $this
     */
    public function setText($text)
    {
        $this->contentArray['text'] = $text;

        return $this;
    }

    /**
     * @desc   addImg 添加帖子详情图片地址
     * @author chenmingming
     *
     * @param string $imgsJson 图片地址数组 json
     *
     * @return $this
     */
    public function setImgs($imgsJson)
    {
        $imgsArray                  = json_decode($imgsJson, true);
        $this->contentArray['imgs'] = $imgsArray;

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
     * @return Post
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
     * Set collectCount
     *
     * @param integer $collectCount
     *
     * @return Post
     */
    public function setCollectCount($collectCount)
    {
        $this->collectCount = $collectCount;

        return $this;
    }

    /**
     * Get collectCount
     *
     * @return integer
     */
    public function getCollectCount()
    {
        return $this->collectCount;
    }

    /**
     * Set commentCount
     *
     * @param integer $commentCount
     *
     * @return Post
     */
    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;

        return $this;
    }

    /**
     * Get commentCount
     *
     * @return integer
     */
    public function getCommentCount()
    {
        return $this->commentCount;
    }

    /**
     * Set isTop
     *
     * @param integer $isTop
     *
     * @return Post
     */
    public function setIsTop($isTop)
    {
        $this->isTop = $isTop == true ? 1 : 0;

        return $this;
    }

    /**
     *
     * getIsboolTop @desc
     *
     * @author wangjuan
     * @return bool
     */
    public function getIsTop()
    {
        return $this->isTop == 1;
    }

    /**
     * Set isIntro
     *
     * @param integer $isIntro
     *
     * @return Post
     */
    public function setIsIntro($isIntro)
    {
        $this->isIntro = $isIntro == true ? 1 : 0;

        return $this;
    }

    /**
     *
     * getIsIntro @desc
     *
     * @author wangjuan
     * @return bool
     */
    public function getIsIntro()
    {
        return $this->isIntro == 1;
    }

    /**
     * Set isDelete
     *
     * @param integer $isDelete
     *
     * @return Post
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete == true ? 1 : 0;

        return $this;
    }

    /**
     * isDelete @desc
     *
     * @author wangjuan
     * @return bool
     */
    public function isDelete()
    {
        return $this->isDelete == 1;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return Post
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
     * @return Post
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
     * Set quan
     *
     * @param \model\entity\Quan $quan
     *
     * @return Post
     */
    public function setQuan(\model\entity\Quan $quan = null)
    {
        $this->quan = $quan;

        return $this;
    }

    /**
     * Get quan
     *
     * @return \model\entity\Quan
     */
    public function getQuan()
    {
        return $this->quan;
    }

    public function filterStr($str)
    {
        $str = str_replace('%', '//%', $str);
        $str = str_replace('_', '//_', $str);
        $str = addslashes($str);

        return $str;
    }

    /**
     * @desc   save
     * @author chenmingming
     */
    public function save()
    {
        if (!$this->content) {
            if ($this->contentArray) {
                $this->setContent();
            }
        }
        parent::save();
    }

    /**
     * @return array
     */
    public function getContentArray()
    {
        if (is_null($this->contentArray)) {
            $this->contentArray = json_decode($this->content, true);
        }

        return $this->contentArray;
    }

    /**
     * @desc   getImgs 获取帖子图片地址数组
     * @author chenmingming
     * @return array
     */
    public function getImgs()
    {
        $this->getContentArray();

        return $this->contentArray['imgs'];
    }

    /**
     * @desc   getText 获取帖子文字内容
     * @author chenmingming
     * @return string
     */
    public function getText()
    {

        $this->getContentArray();

        return $this->contentArray['text'];
    }

    /**
     * getQuanList @desc
     *
     * @author wangjuan
     *
     * @param User $user    用户对象
     * @param Quan $quanObj 圈子对象
     * @param  int $page    页数
     * @param  int $size    每页显示数量
     *
     * @return array
     */
    static public function getQuanList(User $user, Quan $quanObj, $page, $size)
    {

        if (!is_null($quanObj)) {
            $postData = Db::create()->sqlBuilder()
                ->select()
                ->from('post')
                ->where('quan_id')
                ->eq($quanObj->getId())
                ->andWhere('is_delete')
                ->eq(0)
                ->order('add_time desc')
                ->limit(($page - 1) * $size, $size)
                ->fetchAll();
        } else {
            $postData = Db::create()->sqlBuilder()
                ->select()
                ->from('post')
                ->andWhere('is_delete')
                ->eq(0)
                ->order('add_time desc')
                ->limit(($page - 1) * $size, $size)
                ->fetchAll();
        }

        $postList = [];
        foreach ($postData as $v) {
            /** @var User $authorObj */
            $authorObj = User::getInstance($v['user_id']);

            /** @var POST $postObj */
            $postObj = Post::getInstance($v['id']);

            /** @var UserRepos $userRepos */
            $userRepos  = User::getRepository();
            $postList[] = [
                'id'            => $v['id'],
                'author'        => $authorObj->getUserName(),
                'pic'           => $authorObj->getFaceImg(),
                'is_top'        => $postObj->getIsTop(),
                'is_intro'      => $postObj->getIsIntro(),
                'is_collect'    => $user ? $userRepos->isPostCollect($user, $postObj) : false,
                'is_up'         => $user ? $userRepos->isPostUp($user, $postObj) : false,
                'add_time'      => $v['add_time'],
                'title'         => $v['title'],
                'text'          => $postObj->getText(),
                'imgs'          => $postObj->getImgs(),
                'commentList'   => PostComment::getComment($v['id'], 1, 3),
                'upCount'       => $v['up_count'],
                'commentCount'  => $v['comment_count'],
                'collect_count' => $v['collect_count'],
            ];
        }

        return $postList;
    }

    /**
     * getMyList @desc 获取我的帖子列表
     *
     * @author wangjuan
     *
     * @param User $user 用户对象
     * @param  int $page 页数
     * @param  int $size 每页显示数量
     *
     * @return array
     */
    static public function getMyList(User $user, $page, $size)
    {
        $data = Db::create()->sqlBuilder()
            ->select()
            ->from('post')
            ->where('user_id')
            ->eq($user->getId())
            ->andWhere('is_delete')
            ->eq(0)
            ->limit(($page - 1) * $size, $size)
            ->order('add_time desc')
            ->fetchAll();

        $list = [];
        foreach ($data as $v) {
            /** @var Post $postObj */
            $postObj = Post::getInstance($v['id']);
            $list[]  = [
                'id'          => $v['id'],
                'author_name' => $user->getUserName(),
                'face_img'    => $user->getFaceImg(),
                'text'        => $postObj->getText(),
                'imgs'        => $postObj->getImgs(),
                'title'       => $v['title'],
                'add_time'    => $v['add_time'],
            ];
        }

        return $list;
    }

    /**
     *
     * getCollectList @desc 获取帖子收藏列表
     *
     * @author wangjuan
     *
     * @param User $userObj 用户对象
     * @param  int $page    页数
     * @param  int $size    每页显示行数
     *
     * @return array
     */
    static function getCollectList(User $userObj, $page, $size)
    {
        $data = Db::create()->sqlBuilder()
            ->select()
            ->from('post', 'p')
            ->join('post_collect', 'c')
            ->on('p.id', 'c.post_id')
            ->where('c.user_id')
            ->eq($userObj->getId())
            ->order('c.add_time desc')
            ->limit(($page - 1) * $size, $size)
            ->fetchAll();
        $list = [];
        foreach ($data as $v) {
            /** @var Post $postObj */
            $postObj = Post::getInstance($v['id']);
            $list[]  = [
                "title"     => $v['title'],
                "author"    => $postObj->getUser()->getUserName(),
                "face_imgs" => $postObj->getUser()->getFaceImg(),
                "add_time"  => $postObj->getAddTime(),
                "text"      => $postObj->getText(),
                "imgs"      => $postObj->getImgs(),
            ];
        }

        return $list;
    }

    /**
     * getTodayActiveHeadPics @desc  获取今天活跃用户（发帖子多）的头像
     *
     * @author wangjuan
     *
     * @param $quan_id
     *
     * @return array
     */
    static public function getTodayActiveHeadPics($quan_id)
    {
        if (is_null($quan_id)) {
            $sql = 'SELECT
            u.id,
            u.face_img,
            count(*) as post_num
        FROM
            `post` AS p
        INNER JOIN mall_user u ON p.user_id = u.id
        WHERE
           p.add_time >  date_format(now(), "%Y-%m-%d")
        GROUP BY u.id
        ORDER BY
            post_num DESC
        LIMIT 0,
         4';
        } else {
            $sql = 'SELECT
            u.id,
            u.face_img,
            count(*) as post_num
        FROM
            `post` AS p
        INNER JOIN mall_user u ON p.user_id = u.id
        WHERE
            p.quan_id = ' . $quan_id . '
        AND p.add_time >  date_format(now(), "%Y-%m-%d")
        GROUP BY u.id
        ORDER BY
            post_num DESC
        LIMIT 0,
         4';
        }

        $headPics = [];
        $data     = Db::create()->query($sql)->fetchAll();
        foreach ($data as $v) {
            array_push($headPics, $v['face_img']);
        }

        return $headPics;
    }

}

