<?php
namespace Application\Database\Topic;

use Application\Database\Topic\Topic;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class TopicTableGatewayFactory
{
    public function __invoke($services)
    {
        $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Topic());
        return new TableGateway('topic', $adapter, null, $resultSet);
    }
}
