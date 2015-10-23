<?php
namespace Application\Database\Chat;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class ChatModel
{
    public $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
}
