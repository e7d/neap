<?php
namespace User\V1\Rpc\Profile;

use Interop\Container\ContainerInterface;

class ProfileControllerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ProfileController(
            $container->get('Application\Authorization\IdentityService')
        );
    }
}
