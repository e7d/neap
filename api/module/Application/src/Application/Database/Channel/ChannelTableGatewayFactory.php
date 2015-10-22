<?php
namespace Application\Database\Channel;

use Application\Database\Channel\Channel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ChannelTableGatewayFactory
{
    public function __invoke($services)
    {
        $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Channel());
        return new TableGateway('channel', $adapter, null, $resultSet);
    }
}
