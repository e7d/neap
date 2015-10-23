<?php
namespace Application\Database\Topic;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class TopicModel
{
    public $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
}
