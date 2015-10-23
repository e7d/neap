<?php
namespace Application\Database\Follow;

class FollowModelFactory
{
    public function __invoke($services)
    {
        return new FollowModel(
            $services->get('Application\Database\Follow\FollowTableGateway')
        );
    }
}
