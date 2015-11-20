<?php
namespace RTMP\V1\Rpc\Translate;

class TranslateControllerFactory
{
    public function __invoke($controllers)
    {
        $services = $controllers->getServiceLocator();

        return new TranslateController(
            $services->get('Channel\V1\Service\ChannelService')
        );
    }
}
