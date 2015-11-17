<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Topic\V1\Rest\Topic;

class TopicResourceFactory
{
    public function __invoke($services)
    {
        return new TopicResource(
            $services->get('Application\Authorization\IdentityService'),
            $services->get('Topic\V1\Service\TopicService')
        );
    }
}
