<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Stream\V1\Rest\Stream;

class StreamResourceFactory
{
    public function __invoke($services)
    {
        return new StreamResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Stream\V1\Service\StreamService')
        );
    }
}
