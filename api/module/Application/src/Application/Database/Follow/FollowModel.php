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
}
