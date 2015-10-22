<?php
namespace Application\Database\Stream;

class StreamModelFactory
{
    public function __invoke($services)
    {
        return new StreamModel(
            $services->get('Application\Database\Stream\StreamTableGateway'),
            $services
        );
    }
}
