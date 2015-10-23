<?php
namespace Application\Database\Stream;

class StreamHydratorFactory
{
    public function __invoke($services)
    {
        return new StreamHydrator(
            $services->get('Application\Database\Channel\ChannelModel'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
