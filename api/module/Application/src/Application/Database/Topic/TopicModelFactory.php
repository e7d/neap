<?php
namespace Application\Database\Topic;

class TopicModelFactory
{
    public function __invoke($services)
    {
        return new TopicModel(
            $services->get('Application\Database\Topic\TopicTableGateway')
        );
    }
}
