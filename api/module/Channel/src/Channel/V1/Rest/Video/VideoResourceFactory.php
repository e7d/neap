<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Channel\V1\Rest\Video;

class VideoResourceFactory
{
    public function __invoke($services)
    {
        return new VideoResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Channel\Service\ChannelService')
        );
    }
}
