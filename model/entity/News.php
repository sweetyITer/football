<?php

namespace model\entity;

use mmapi\core\Log;
use model\footballModel;
use model\repository\UserRepos;
use mmapi\core\Db;
use mmapi\core\AppException;

class News extends footballModel
{

    /**
     * @var array 帖子详情数组
     */
    private $contentArray;
    /**
     * @var string
     */
    private $groupId = 'teach';

    /**
     * @var string
     */
    private $cover;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $authorId;

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
    private $collectCount = 0;

    /**
     * @var integer
     */
    private $viewCount = 0;

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var string
     */
    private $updateTime;

    /**
     * @var integer
     */
    private $id;

    private $isDelete;

    private $commentCount;

    const COLLECT_SIZE = 5;

    public function __construct()
    {
        $this->addTime = date('Y-m-d H:i:s');
    }

    /**
     * setIsDelete @desc
     *
     * @param $isDelete
     *
     * @return $this
     */
    public function setIsDelete($isDelete)
    {
        $this->isDelete = $isDelete;

        return $this;
    }

    /**
     * getIsDelete @desc
     *
     * @return mixed
     */
    public function getIsDelete()
    {
        return $this->isDelete == 1 ? true : false;
    }

    public function getCommentCount()
    {
        return $this->commentCount;

    }

    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;

        return $this;
    }

    /**
     * Set groupId
     *
     * @param string $groupId
     *
     * @return Video
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

        return $this;
    }

    /**
     * Get groupId
     *
     * @return string
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * Set cover
     *
     * @param string $cover
     *
     * @return Video
     */
    public function setCover($cover)
    {
        $this->cover = $cover;

        return $this;
    }

    /**
     *
     * setAuthor @desc
     *
     * @author wangjuan
     *
     * @param $author_id
     *
     * @return $this
     */
    public function setAuthor($authorId)
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * getAuthor @desc
     *
     * @return string
     */
    public function getAuthor()
    {

        return $this->authorId;

    }

    /**
     * Get cover
     *
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Video
     */
    public function setTitle($title)
    {
        $this->title = $title;

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
     * Get content
     *
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
     * Set collectCount
     *
     * @param integer $collectCount
     *
     * @return Video
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
     *
     * setViewCount @desc
     *
     * @param $viewCount
     *
     * @return $this
     */
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;

        return $this;
    }

    /**
     * getViewCount @desc
     *
     * @return int
     */

    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * Set addTime
     *
     * @param string $addTime
     *
     * @return Video
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
     * setUpdateTime @desc
     *
     * @param $updateTime
     *
     * @return $this
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return string
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
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
     * getList @desc 获取资讯列表
     *
     * @author wangjuan
     *
     * @param  string $group_id 分组
     * @param  int    $page     页数
     * @param  int    $size     每页显示数量
     *
     * @return array
     */
    static public function getList($group_id, $page, $size)
    {
        $data = Db::create()->sqlBuilder()
            ->select()
            ->from('news')
            ->where('group_id')
            ->eq($group_id)
            ->limit(($page - 1) * $size, $size)
            ->order('update_time desc')
            ->fetchAll();
        $list = [];
        foreach ($data as $v) {
            /** @var News $newObj */
            $newObj = News::getInstance($v['id']);
            /** @var UserRepos $userRepos */
            $list[] = [
                "id"            => $v['id'],
                "title"         => $v["title"],
                "cover"         => $v['cover'],
                "text"          => $newObj->getText(),
                "collect_count" => $v['collect_count'],
                "view_count"    => $v['view_count'],
                "is_newest"     => $newObj->getId() == $newObj->isNewest() ? true : false,
                "is_hot"        => $newObj->isHot() == $newObj->getId() ? true : false,
            ];
        }

        return $list;
    }

    /**
     *
     * isNewest @desc 返回最新资讯的id
     *
     * @author wangjuan
     * @return int
     *
     */
    public function isNewest()
    {
        return (int)Db::create()->sqlBuilder()
            ->select('id')
            ->from('news')
            ->where('is_delete')
            ->eq(0)
            ->order('update_time desc')
            ->getField('id');
    }

    /**
     * isHot @desc 判断该资讯是不是最热的
     *
     * @author wangjuan
     * @return bool
     */
    public function isHot()
    {
        return (int)Db::create()->sqlBuilder()
            ->select('max(view_count), id')
            ->from('news')
            ->where('is_delete')
            ->eq(0)
            ->getField('id');
    }

    /**
     * setContent @desc
     *
     * @author wangjuan
     *
     * @param null $content
     *
     * @return $this
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
     * getCollectList @desc 获取咨询收藏列表
     *
     * @author wangjuan
     *
     * @param User $userObj 用户对象
     * @param  int $page 页数
     * @param  int $size 每页显示行数
     *
     * @return array
     */
    static function getCollectList(User $userObj, $page, $size)
    {
        $data = Db::create()->sqlBuilder()
            ->select()
            ->from('news', 'n')
            ->join('news_collect', 'c')
            ->on('n.id', 'c.news_id')
            ->where('c.user_id')
            ->eq($userObj->getId())
            ->order('c.add_time desc')
            ->limit(($page - 1) * $size, $size)
            ->fetchAll();
        $list = [];
        foreach ($data as $v) {

            /** @var News $newsObj */
            $newsObj = News::getInstance($v['id']);

            /** @var UserRepos $userRepos */
            $userRepos = User::getRepository();
            $list[]    = [
                "title"         => $v['title'],
                "text"          => $newsObj->getText(),
                "cover"         => $newsObj->getCover(),
                "collect_count" => $newsObj->getCollectCount(),
                "view_count"    => $newsObj->getViewCount(),
                "is_collect"    => $userRepos->isNewsCollect($userObj, $newsObj),
            ];
        }

        return $list;
    }

}
