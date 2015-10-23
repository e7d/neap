<?php
namespace Application\Database\Block;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class BlockModel
{
    public $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
}
