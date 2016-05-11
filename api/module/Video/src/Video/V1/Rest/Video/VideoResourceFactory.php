<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Video\V1\Rest\Video;

class VideoResourceFactory
{
    public function __invoke($serviceManager)
    {
        return new VideoResource(
            $serviceManager->get('Application\Authorization\IdentityService'),
            $serviceManager->get('Video\V1\Service\VideoService')
        );
    }
}
