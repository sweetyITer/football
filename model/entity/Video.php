<?php

namespace model\entity;

use mmapi\core\Model;
use mmapi\core\Db;

/**
 * Video
 */
class Video extends Model
{
    /**
     * @var string
     */
    private $groupId = 'teach';

    /**
     * @var string
     */
    private $cover;

    /**
     * @var integer
     */
    private $duration;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $title;

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
    private $commentCount = 0;

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $id;

    const COLLECT_SIZE = 3;

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
     * Get cover
     *
     * @return string
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Video
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Video
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
     * Set content
     *
     * @param string $content
     *
     * @return Video
     */
    public function setContent($content)
    {
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
     * @return Video
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
     * Set commentCount
     *
     * @param integer $commentCount
     *
     * @return Video
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
     * getCollectList @desc 获取视频收藏列表
     *
     * @author wangjuan
     *
     * @param User $userObj 用户对象
     * @param int  $page 页数
     * @param int  $size 每页显示行数
     *
     * @return array
     */
    static public function getCollectList(User $userObj, $page, $size)
    {
        return Db::create()->sqlBuilder()
            ->select('v.cover, v.title')
            ->from('video', 'v')
            ->join('video_collect', 'c')
            ->on('v.id', 'c.video_id')
            ->where('c.user_id')
            ->eq($userObj->getId())
            ->order('c.add_time desc')
            ->limit(($page - 1) * $size, $size)
            ->fetchAll();
    }

}

