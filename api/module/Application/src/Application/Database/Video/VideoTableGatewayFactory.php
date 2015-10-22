<?php
namespace Application\Database\Video;

use Application\Database\Video\Video;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class VideoTableGatewayFactory
{
    public function __invoke($services)
    {
        $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Video());
        return new TableGateway('video', $adapter, null, $resultSet);
    }
}
