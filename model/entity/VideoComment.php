<?php

namespace model\entity;

use mmapi\core\Model;

/**
 * VideoComment
 */
class VideoComment extends Model
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var string
     */
    private $addTime;

    /**
     * @var integer
     */
    private $upCount = 0;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \model\entity\User
     */
    private $user;

    /**
     * @var \model\entity\Video
     */
    private $video;

    public function __construct()
    {
        $this->addTime = date('Y-m-d H:i:s');
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return VideoComment
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
     * Set addTime
     *
     * @param string $addTime
     *
     * @return VideoComment
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
     * Set upCount
     *
     * @param integer $upCount
     *
     * @return VideoComment
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
     * @return VideoComment
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
     * Set video
     *
     * @param \model\entity\Video $video
     *
     * @return VideoComment
     */
    public function setVideo(\model\entity\Video $video = null)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return \model\entity\Video
     */
    public function getVideo()
    {
        return $this->video;
    }
}

