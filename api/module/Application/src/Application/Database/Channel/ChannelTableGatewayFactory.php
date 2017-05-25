<?php
/**
 * Neap (http://neap.io/)
 *
 * @package   Neap
 * @author    Michaël "e7d" Ferrand <michael@e7d.io>
 * @copyright 2017 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 * @link      https://github.com/e7d/neap
 *
 * PHP version 7.1
 */

namespace Application\Database\Channel;

use Application\Database\Channel\Channel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceManager;

/**
 * ChannelTableGatewayFactory
 */
class ChannelTableGatewayFactory
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
        $resultSet->setArrayObjectPrototype(new Channel());
        return new TableGateway('channel', $adapter, null, $resultSet);
    }
}
