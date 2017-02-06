<?php
/**
 * Created by PhpStorm.
 * User: chenmingming
 * Date: 2016/12/15
 * Time: 00:51
 */

namespace model\repository;

use Doctrine\ORM\EntityRepository;

class AdminMasterRepository extends EntityRepository
{
    public function getList()
    {
        return 123;
    }
}