<?php
namespace model\entity;

use mmapi\core\Model;

/**
 * AdminMasterGroup
 */
class AdminMasterGroup extends Model
{
    /**
     * @var string
     */
    private $name = '';

    /**
     * @var integer
     */
    private $id;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return AdminMasterGroup
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
}
