<?php
/**
 * Neap (http://neap.io/)
 *
 * @package   Neap
 * @author    Michaël "e7d" Ferrand <michael@e7d.io>
 * @copyright 2017 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 * @link      https://github.com/e7d/neap
 *
 * PHP version 7.1
 */

namespace ChatTest\V1\Service;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class ChatServiceTest extends AbstractControllerTestCase
{
    private $serviceManager;

    public function setUp()
    {
        $this->setApplicationConfig(
            include './config/tests.config.php'
        );
        parent::setUp();
        $this->serviceManager = $this->getApplicationServiceLocator();
        $this->serviceManager->setAllowOverride(true);
    }

    public function testClassType()
    {
        $chatService = $this->serviceManager->get('Chat\V1\Service\ChatService');

        $this->assertInstanceOf('Chat\V1\Service\ChatService', $chatService);
    }

    public function testFetch()
    {
        $chatService = $this->serviceManager->get('Chat\V1\Service\ChatService');

        $chatId = 'f598d270-281b-40c9-a2d8-eb35b56e9412'; // Jax chat id
        $chatEntity = $chatService->fetch($chatId);

        $this->assertInstanceOf('ZF\Hal\Entity', $chatEntity);
        $this->assertEquals($chatId, $chatEntity->entity->chat_id);
    }

    public function testFetchInvalidChat()
    {
        $chatService = $this->serviceManager->get('Chat\V1\Service\ChatService');

        $chatId = '00000000-0000-0000-0000-000000000000'; // Invalid chat id
        $chatEntity = $chatService->fetch($chatId);

        $this->assertNull($chatEntity);
    }

    public function testFetchByChannel()
    {
        $chatService = $this->serviceManager->get('Chat\V1\Service\ChatService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $chatEntity = $chatService->fetchByChannel($channelId);

        $this->assertInstanceOf('ZF\Hal\Entity', $chatEntity);
        $this->assertEquals($channelId, $chatEntity->entity->channel_id);
    }

    public function testFetchByInvalidChannel()
    {
        $chatService = $this->serviceManager->get('Chat\V1\Service\ChatService');

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid chat id
        $chatEntity = $chatService->fetchByChannel($userId);

        $this->assertNull($chatEntity);
    }
}
