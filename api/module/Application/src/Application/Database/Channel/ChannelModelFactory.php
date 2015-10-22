<?php
namespace Application\Database\Channel;

class ChannelModelFactory
{
    public function __invoke($services)
    {
        return new ChannelModel(
            $services->get('Application\Database\Channel\ChannelTableGateway')
        );
    }
}
