*<?php
namespace Application\Database\Chat;

use Application\Database\Chat\Chat;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ChatTableGatewayFactory
{
    public function __invoke($services)
    {
        $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Chat());
        return new TableGateway('chat', $adapter, null, $resultSet);
    }
}
