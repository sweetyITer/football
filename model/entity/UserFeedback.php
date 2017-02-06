<?php

namespace model\entity;
use mmapi\api\ApiException;
use mmapi\core\Model;

/**
 * UserFeedback
 */
class UserFeedback extends Model
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
    private $id;

    /**
     * @var \model\entity\User
     */
    private $user;

    /**
     * setContent @desc
     * @author wangjuan
     * @param $content
     *
     * @return $this
     * @throws ApiException
     */
    public function setContent($content)
    {
        $this->content = $this->filterStr($content);
        if (mb_strlen($this->content) > 50) {
            throw new ApiException('帖子内容长度不合法', 'CONTENT_INVALID');
        }
        $this->content = $content;

        return $this;


    }

    public function filterStr($str)
    {
        $str = str_replace('%', '//%', $str);
        $str = str_replace('_', '//_', $str);
        $str = addslashes($str);

        return $str;
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
     * @return UserFeedback
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
     * @return UserFeedback
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
}

