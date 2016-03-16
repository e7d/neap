<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Hydrator;

use Application\Database\Stream\Stream;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class HydratorTest extends AbstractControllerTestCase
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
        $hydratorStub = $this->getMockForAbstractClass('Application\Hydrator\Hydrator');

        $this->assertInstanceOf('Application\Hydrator\Hydrator', $hydratorStub);
    }

    public function testHydrate()
    {
        $hydratorStub = $this->getMockForAbstractClass('Application\Hydrator\Hydrator');

        $streamId = '680b705c-6eaa-4327-a441-6ebea32ae3c8';
        $stream = new Stream();
        $data = array(
            'stream_id' => $streamId,
            'channel_id' => 'd644139f-187f-4a19-aab7-00a4f285eab4',
            'title' => 'Stream title',
            'topic_id' => 'ca7b9204-a83f-4871-a284-5ffe1c75e39f',
            'topic' => 'Stream topic',
            'media_info' => '{}',
            'viewers' => 1337,
            'created_at' => '2016-01-16 20:53:04.025400+0000',
            'updated_at' => '2016-01-17 09:34:07.785600+0000',
            'ended_at' => null,
        );
        $result = $hydratorStub->hydrate($data, $stream);

        $this->assertInstanceOf('ZF\Hal\Entity', $result);
        $this->assertEquals($streamId, $result->entity->stream_id);
    }

    public function testExtract()
    {
        $hydratorStub = $this->getMockForAbstractClass('Application\Hydrator\Hydrator');

        $object = new \stdClass();
        $object->test = 'test';

        $extract = $hydratorStub->extract($object);

        $this->assertEquals($object, $extract);
    }

    public function testExtractArray()
    {
        $hydratorStub = $this->getMockForAbstractClass('Application\Hydrator\Hydrator');

        $object = new \stdClass();
        $object->test = 'test';

        $extract = $hydratorStub->extractArray($object);

        $this->assertEquals(
            array(
                'test' => 'test'
            ),
            $extract
        );
    }

    public function testGetAndSetParam()
    {
        $hydratorStub = $this->getMockForAbstractClass('Application\Hydrator\Hydrator');

        $hydratorStub->setParam('test', 'test');

        $this->assertEquals('test', $hydratorStub->getParam('test'));
    }

    public function testGetAndSetArrayParam()
    {
        $hydratorStub = $this->getMockForAbstractClass('Application\Hydrator\Hydrator');

        $hydratorStub->setParam(array('test' => 'test'));

        $this->assertEquals('test', $hydratorStub->getParam('test'));
    }
}
