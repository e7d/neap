<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Chat\V1\Service;

class ChatServiceFactory
{
    public function __invoke($services)
    {
        return new ChatService(
            $services->get('Application\Database\Chat\ChatModel'),
            $services->get('Application\Hydrator\Chat\ChatHydrator')
        );
    }
}
