<?php
namespace Status\V1\Rpc\Stats;

class StatsControllerFactory
{
    public function __invoke($controllers)
    {
        return new StatsController();
    }
}
