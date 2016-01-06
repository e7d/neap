<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Channel\V1\Rest\StreamKey;

class StreamKeyResourceFactory
{
    public function __invoke($services)
    {
        return new StreamKeyResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Channel\V1\Service\ChannelService')
        );
    }
}
