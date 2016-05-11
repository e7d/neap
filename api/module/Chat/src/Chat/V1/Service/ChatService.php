<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Chat\V1\Service;

class ChatService
{
    private $serviceManager;

    public function __construct($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function fetch($chatId)
    {
        $chatModel = $this->serviceManager->get('Application\Database\Chat\ChatModel');
        $chatHydrator = $this->serviceManager->get('Application\Hydrator\Chat\ChatHydrator');

        $chat = $chatModel->fetch($chatId);
        if (!$chat) {
            return null;
        }

        $chatHydrator->setParam('linkChannel', true);
        $chatHydrator->setParam('linkUser', true);

        return $chatHydrator->buildEntity($chat);
    }

    public function fetchByChannel($channelId)
    {
        $chatModel = $this->serviceManager->get('Application\Database\Chat\ChatModel');
        $chatHydrator = $this->serviceManager->get('Application\Hydrator\Chat\ChatHydrator');

        $chat = $chatModel->fetchByChannel($channelId);
        if (!$chat) {
            return null;
        }

        $chatHydrator->setParam('embedChannel', true);

        return $chatHydrator->buildEntity($chat);
    }
}
