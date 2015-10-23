<?php
namespace Application\Database\Mod;

use Application\Database\Mod\Mod;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ModTableGatewayFactory
{
    public function __invoke($services)
    {
        $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Mod());
        return new TableGateway('mod', $adapter, null, $resultSet);
    }
}
