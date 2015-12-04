<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Stream;

use Application\Database\Stream\Stream;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class StreamTableGatewayFactory
{
    public function __invoke($services)
    {
        $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Stream());
        return new TableGateway('stream', $adapter, null, $resultSet);
    }
}
