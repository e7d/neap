<?php
namespace Application\Database\Panel;

use Application\Database\Panel\Panel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class PanelTableGatewayFactory
{
    public function __invoke($services)
    {
        $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Panel());
        return new TableGateway('panel', $adapter, null, $resultSet);
    }
}
