<?php
namespace Application\Database\User;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class UserModel
{
    public $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetch($id)
    {
        $rowset = $this->tableGateway->select(array('user_id' => $id));
        $user = $rowset->current();
        if (!$user) {
            return null;
        }

        return $user;
    }
}
