<?php
namespace Application\Database\Block;

use Application\Database\Block\Block;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class BlockTableGatewayFactory
{
    public function __invoke($services)
    {
        $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Block());
        return new TableGateway('block', $adapter, null, $resultSet);
    }
}
