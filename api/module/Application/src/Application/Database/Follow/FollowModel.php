<?php
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
