<?php
namespace Team\V1\Rest\Team;

class TeamResourceFactory
{
    public function __invoke($services)
    {
        return new TeamResource();
    }
}
