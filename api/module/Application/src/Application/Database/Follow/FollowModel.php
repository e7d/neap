<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Follow;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class FollowModel
{
    public $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchByUser($userId)
    {
        $where = new Where();
        $where->equalTo('user.user_id', $userId);

        $sqlSelect = $this->tableGateway->getSql()->select()->where($where);
        $sqlSelect->join('user', 'user.user_id = follow.user_id', array(), 'left');

        $rowset = $this->tableGateway->selectWith($sqlSelect);
        $follow = $rowset->current();
        if (!$follow) {
            return null;
        }

        return $follow;
    }
}
