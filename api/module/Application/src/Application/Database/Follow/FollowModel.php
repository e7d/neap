<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Follow;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class FollowModel extends AbstractModel
{
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function selectByUser($userId)
    {
        $where = new Where();
        $where->equalTo('follow.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->where($where);

        return $select;
    }

    public function fetchByUser($userId)
    {
        return $this->selectAll(
            $this->selectByUser($userId)
        );
    }
}
