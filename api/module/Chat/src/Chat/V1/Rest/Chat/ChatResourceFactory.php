<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Chat\V1\Rest\Chat;

class ChatResourceFactory
{
    public function __invoke($serviceManager)
    {
        return new ChatResource(
            $serviceManager->get('Application\Authorization\IdentityService'),
            $serviceManager->get('Chat\V1\Service\ChatService')
        );
    }
}
