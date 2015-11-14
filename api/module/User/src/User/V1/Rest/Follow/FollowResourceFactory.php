<?php
namespace User\V1\Rest\Follow;

class FollowResourceFactory
{
    public function __invoke($services)
    {
        return new FollowResource();
    }
}
