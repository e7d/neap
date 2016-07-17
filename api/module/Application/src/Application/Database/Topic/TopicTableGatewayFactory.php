<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Topic;

use Application\Database\Topic\Topic;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceManager;

/**
 * TopicTableGatewayFactory
 */
class TopicTableGatewayFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return TableGateway
     */
    public function __invoke(ServiceManager $serviceManager)
    {
        $adapter = $serviceManager->get('Application\Database\DatabaseService')->getAdapter();
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Topic());
        return new TableGateway('topic', $adapter, null, $resultSet);
    }
}
