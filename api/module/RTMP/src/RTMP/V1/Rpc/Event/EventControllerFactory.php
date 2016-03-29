<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace RTMP\V1\Rpc\Event;

class EventControllerFactory
{
    public function __invoke($controllers)
    {
        $serviceManager = $controllers->getServiceLocator();

        return new EventController(
            $serviceManager->get('Application\Database\Channel\ChannelModel'),
            $serviceManager->get('Application\Database\Ingest\IngestModel'),
            $serviceManager->get('Application\Database\Stream\StreamModel')
        );
    }
}
