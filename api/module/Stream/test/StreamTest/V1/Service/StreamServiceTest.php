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

namespace StreamTest\V1\Service;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class StreamServiceTest extends AbstractControllerTestCase
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
        $streamService = $this->serviceManager->get('Stream\V1\Service\StreamService');

        $this->assertInstanceOf('Stream\V1\Service\StreamService', $streamService);
    }

    public function testFetchAll()
    {
        $streamService = $this->serviceManager->get('Stream\V1\Service\StreamService');

        $params = array(
            'all' => true
        );
        $streamCollection = $streamService->fetchAll($params);

        $this->assertInstanceOf('Stream\V1\Rest\Stream\StreamCollection', $streamCollection);
        $this->assertTrue(0 < $streamCollection->getTotalItemCount());

        $streamEntity = $streamCollection->getCurrentItems()->current();

        $this->assertInstanceOf('ZF\Hal\Entity', $streamEntity);
    }

    public function testFetchAllLive()
    {
        $streamService = $this->serviceManager->get('Stream\V1\Service\StreamService');

        $streamCollection = $streamService->fetchAll();

        $this->assertInstanceOf('Stream\V1\Rest\Stream\StreamCollection', $streamCollection);
        $this->assertTrue(0 < $streamCollection->getTotalItemCount());

        $streamEntity = $streamCollection->getCurrentItems()->current();

        $this->assertInstanceOf('ZF\Hal\Entity', $streamEntity);
    }

    public function testFetch()
    {
        $streamService = $this->serviceManager->get('Stream\V1\Service\StreamService');

        $streamId = '4ea7abe9-1840-46b5-bf50-f0a23625f61f'; // Jax stream id
        $streamEntity = $streamService->fetch($streamId);

        $this->assertInstanceOf('ZF\Hal\Entity', $streamEntity);
        $this->assertEquals($streamId, $streamEntity->entity->stream_id);
    }

    public function testFetchInvalidStream()
    {
        $streamService = $this->serviceManager->get('Stream\V1\Service\StreamService');

        $streamId = '00000000-0000-0000-0000-000000000000'; // Invalid stream id
        $streamEntity = $streamService->fetch($streamId);

        $this->assertNull($streamEntity);
    }

    public function testFetchByChannel()
    {
        $streamService = $this->serviceManager->get('Stream\V1\Service\StreamService');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $streamEntity = $streamService->fetchByChannel($channelId);

        $this->assertInstanceOf('ZF\Hal\Entity', $streamEntity);
        $this->assertFalse(isset($streamEntity->entity->stream_key));
    }

    public function testFetchByInvalidChannel()
    {
        $streamService = $this->serviceManager->get('Stream\V1\Service\StreamService');

        $channelId = '00000000-0000-0000-0000-000000000000'; // Invalid channel id
        $streamEntity = $streamService->fetchByChannel($channelId);

        $this->assertNull($streamEntity);
    }

    public function testFetchByUser()
    {
        $streamService = $this->serviceManager->get('Stream\V1\Service\StreamService');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $streamEntity = $streamService->fetchByUser($userId);

        $this->assertInstanceOf('ZF\Hal\Entity', $streamEntity);
        $this->assertFalse(isset($streamEntity->entity->stream_key));
    }

    public function testFetchByInvalidUser()
    {
        $streamService = $this->serviceManager->get('Stream\V1\Service\StreamService');

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $streamEntity = $streamService->fetchByUser($userId);

        $this->assertNull($streamEntity);
    }

    public function testFetchStats()
    {
        $streamService = $this->serviceManager->get('Stream\V1\Service\StreamService');

        $params = array();
        $streamStats = $streamService->fetchStats($params);

        $this->assertTrue(is_array($streamStats));
        $this->assertTrue(0 < $streamStats['streams']);
        $this->assertTrue(0 < $streamStats['viewers']);
    }

    public function testFetchAllStats()
    {
        $streamService = $this->serviceManager->get('Stream\V1\Service\StreamService');

        $params = array(
            'all' => true
        );
        $streamStats = $streamService->fetchStats($params);

        $this->assertTrue(is_array($streamStats));
        $this->assertTrue(0 < $streamStats['streams']);
        $this->assertTrue(0 < $streamStats['viewers']);
    }
}
