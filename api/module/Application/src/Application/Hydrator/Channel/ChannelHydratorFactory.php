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

namespace Application\Hydrator\Channel;

use Zend\ServiceManager\ServiceManager;

/**
 * ChannelHydratorFactory
 */
class ChannelHydratorFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return ChannelHydrator
     */
    public function __invoke(ServiceManager $serviceManager)
    {
        return new ChannelHydrator(
            $serviceManager->get('Application\Database\Chat\ChatModel'),
            $serviceManager->get('Application\Database\Panel\PanelModel'),
            $serviceManager->get('Application\Database\Stream\StreamModel'),
            $serviceManager->get('Application\Database\User\UserModel')
        );
    }
}
