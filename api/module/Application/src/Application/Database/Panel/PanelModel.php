<?php
namespace Application\Database\Panel;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class PanelModel
{
    public $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
}
