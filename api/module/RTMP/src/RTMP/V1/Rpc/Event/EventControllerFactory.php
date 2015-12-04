<?php
namespace RTMP\V1\Rpc\Event;

class EventControllerFactory
{
    public function __invoke($controllers)
    {
        $services = $controllers->getServiceLocator();

        return new EventController(
            $services->get('Application\Database\Channel\ChannelModel'),
            $services->get('Application\Database\Ingest\IngestModel'),
            $services->get('Application\Database\Stream\StreamModel')
        );
    }
}
