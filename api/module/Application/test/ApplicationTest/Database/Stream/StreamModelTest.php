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

namespace ApplicationTest\Database\Stream;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class StreamModelTest extends AbstractControllerTestCase
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
        $streamModel = $this->serviceManager->get('Application\Database\Stream\StreamModel');

        $this->assertInstanceOf('Application\Database\Stream\StreamModel', $streamModel);
    }

    public function testGetTableGateway()
    {
        $streamModel = $this->serviceManager->get('Application\Database\Stream\StreamModel');

        $tableGateway = $streamModel->getTableGateway();
        $this->assertInstanceOf('Zend\Db\TableGateway\TableGateway', $tableGateway);
    }

    public function testGetSqlSelect()
    {
        $streamModel = $this->serviceManager->get('Application\Database\Stream\StreamModel');
        $select = $streamModel->getSqlSelect();

        $this->assertInstanceOf('Zend\Db\Sql\Select', $select);
        $this->assertEquals('SELECT "stream".* FROM "stream"', $select->getSqlString());
    }

    public function testCreate()
    {
        $streamModel = $this->serviceManager->get('Application\Database\Stream\StreamModel');

        $data = array(
            'title' => 'test stream',
            'channel_id' => '23a057b7-a5b2-48da-ae73-6fd130e8c55e', // Jax channel id
            'ingest_id' => 'c3aae4dc-dd8d-4e81-a151-7ba30cec1b4a', // neap ingest id
            'topic' => 'Test',
        );
        $rows = $streamModel->create($data);
        $this->assertEquals(1, $rows);
    }

    public function testFetch()
    {
        $streamModel = $this->serviceManager->get('Application\Database\Stream\StreamModel');

        $streamId = '823084a6-3f6e-4305-a21b-e28e9f47c43c'; // Jax's channel stream id
        $stream = $streamModel->fetch($streamId);
        $this->assertInstanceOf('Application\Database\Stream\Stream', $stream);
        $this->assertEquals($streamId, $stream->stream_id);

        $streamId = '00000000-0000-0000-0000-000000000000'; // Invalid stream id
        $stream = $streamModel->fetch($streamId);
        $this->assertNull($stream);
    }

    public function testFetchByChannel()
    {
        $streamModel = $this->serviceManager->get('Application\Database\Stream\StreamModel');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $stream = $streamModel->fetchByChannel($channelId);
        $this->assertInstanceOf('Application\Database\Stream\Stream', $stream);

        $channelId = '00000000-0000-0000-0000-000000000000'; // Invalid channel id
        $stream = $streamModel->fetchByChannel($channelId);
        $this->assertNull($stream);
    }

    public function testFetchByStreamKey()
    {
        $streamModel = $this->serviceManager->get('Application\Database\Stream\StreamModel');

        $streamKey = 'live_1b0f5864_d637993a8bf849b3c8aad171'; // Jax stream key
        $stream = $streamModel->fetchByStreamKey($streamKey);
        $this->assertInstanceOf('Application\Database\Stream\Stream', $stream);

        $streamKey = 'live_00000000_000000000000000000000000'; // Invalid stream key
        $stream = $streamModel->fetchByStreamKey($streamKey);
        $this->assertNull($stream);
    }

    public function testFetchByUser()
    {
        $streamModel = $this->serviceManager->get('Application\Database\Stream\StreamModel');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $stream = $streamModel->fetchByUser($userId);
        $this->assertInstanceOf('Application\Database\Stream\Stream', $stream);

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid stream key
        $live = true;
        $stream = $streamModel->fetchByUser($userId, $live);
        $this->assertNull($stream);
    }

    public function testFetchStats()
    {
        $streamModel = $this->serviceManager->get('Application\Database\Stream\StreamModel');

        $live = true;
        $stats = $streamModel->fetchStats($live);
        $this->assertInternalType('array', $stats);

        $stats = $streamModel->fetchStats();
        $this->assertInternalType('array', $stats);
    }

    public function testUpdate()
    {
        $streamModel = $this->serviceManager->get('Application\Database\Stream\StreamModel');

        $data = array(
            'viewers' => '500'
        );

        $streamId = '823084a6-3f6e-4305-a21b-e28e9f47c43c'; // Jax's channel stream id
        $stream = $streamModel->update($streamId, $data);
        $this->assertInstanceOf('Application\Database\Stream\Stream', $stream);
        $this->assertEquals($streamId, $stream->stream_id);
        $this->assertEquals($data['viewers'], $stream->viewers);

        $streamId = '00000000-0000-0000-0000-000000000000'; // Invalid stream id
        $stream = $streamModel->update($streamId, $data);
        $this->assertNull($stream);
    }
}
