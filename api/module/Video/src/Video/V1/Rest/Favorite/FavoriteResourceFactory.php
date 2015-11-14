<?php
namespace Video\V1\Rest\Favorite;

class FavoriteResourceFactory
{
    public function __invoke($services)
    {
        return new FavoriteResource();
    }
}
