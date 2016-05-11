<?php
namespace Video\V1\Rest\Favorite;

class FavoriteResourceFactory
{
    public function __invoke($serviceManager)
    {
        return new FavoriteResource();
    }
}
