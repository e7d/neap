<?php
namespace Application\Database\Mod;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class ModModel
{
    public $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
}
