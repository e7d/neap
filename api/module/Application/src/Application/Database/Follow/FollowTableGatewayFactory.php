<?php
namespace Application\Database\Follow;

use Application\Database\Follow\Follow;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class FollowTableGatewayFactory
{
    public function __invoke($services)
    {
        $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Follow());
        return new TableGateway('follow', $adapter, null, $resultSet);
    }
}
