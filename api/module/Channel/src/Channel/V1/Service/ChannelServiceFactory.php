<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Channel\V1\Service;

class ChannelServiceFactory
{
    public function __invoke($services)
    {
        return new ChannelService(
            $services->get('Application\Database\Channel\ChannelModel'),
            $services->get('Application\Hydrator\Channel\ChannelHydrator'),
            $services->get('Application\Database\Follow\FollowModel'),
            $services->get('Application\Hydrator\Follow\FollowHydrator'),
            $services->get('Application\Database\User\UserModel'),
            $services->get('Application\Hydrator\User\UserHydrator'),
            $services->get('Application\Database\Video\VideoModel'),
            $services->get('Application\Hydrator\Video\VideoHydrator')
        );
    }
}
