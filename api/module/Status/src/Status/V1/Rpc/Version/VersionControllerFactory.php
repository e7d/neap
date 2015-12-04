<?php
namespace Status\V1\Rpc\Version;

class VersionControllerFactory
{
    public function __invoke($controllers)
    {
        return new VersionController();
    }
}
