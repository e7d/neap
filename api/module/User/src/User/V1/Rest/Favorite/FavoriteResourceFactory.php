<?php
namespace User\V1\Rest\Favorite;

class FavoriteResourceFactory
{
    public function __invoke($services)
    {
        return new FavoriteResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('User\V1\Service\UserService')
        );
    }
}
