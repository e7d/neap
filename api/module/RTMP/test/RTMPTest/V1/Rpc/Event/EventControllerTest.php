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

namespace RTMPTest\V1\Rpc\Event;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class EventControllerTest extends AbstractHttpControllerTestCase
{
    private $serviceManager;

    public function setUp()
    {
        $this->setApplicationConfig(
            include './config/tests.config.php'
        );
        parent::setUp();

        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    }

    public function testEventActionCanStartPublish()
    {
        $_POST = array(
            'app' => 'transcode',
            'name' => 'live_1b0f5864_d637993a8bf849b3c8aad171',
            'call' => 'publish',
            'tcurl' => 'http://rtmp.neap.dev/transcode',
        );

        $request = $this->getRequest();
        $request->setMethod('POST');

        $headers = $request->getHeaders();
        $headers->addHeaderLine('Accept', 'application/json');

        $this->dispatch('/rtmp/event');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('rtmp');
        $this->assertControllerName('RTMP\V1\Rpc\Event\Controller');
        $this->assertControllerClass('EventController');
        $this->assertMatchedRouteName('rtmp.rpc.event');
    }

    public function testEventActionCanEndPublish()
    {
        $_POST = array(
            'app' => 'transcode',
            'name' => 'live_1b0f5864_d637993a8bf849b3c8aad171',
            'call' => 'publish_done',
            'tcurl' => 'http://rtmp.neap.dev/transcode',
        );

        $request = $this->getRequest();
        $request->setMethod('POST');

        $headers = $request->getHeaders();
        $headers->addHeaderLine('Accept', 'application/json');

        $this->dispatch('/rtmp/event');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('rtmp');
        $this->assertControllerName('RTMP\V1\Rpc\Event\Controller');
        $this->assertControllerClass('EventController');
        $this->assertMatchedRouteName('rtmp.rpc.event');
    }

    public function testEventActionStartPublicRejectsBadStreamKey()
    {
        $_POST = array(
            'app' => 'transcode',
            'name' => 'invalid',
            'call' => 'publish',
            'tcurl' => 'http://rtmp.neap.dev/transcode',
        );

        $request = $this->getRequest();
        $request->setMethod('POST');

        $headers = $request->getHeaders();
        $headers->addHeaderLine('Accept', 'application/json');

        $this->dispatch('/rtmp/event');
        $this->assertResponseStatusCode(403);

        $this->assertModuleName('rtmp');
        $this->assertControllerName('RTMP\V1\Rpc\Event\Controller');
        $this->assertControllerClass('EventController');
        $this->assertMatchedRouteName('rtmp.rpc.event');
    }

    public function testEventActionEndPublicRejectsBadStreamKey()
    {
        $_POST = array(
            'app' => 'transcode',
            'name' => 'invalid',
            'call' => 'publish_done',
            'tcurl' => 'http://rtmp.neap.dev/transcode',
        );

        $request = $this->getRequest();
        $request->setMethod('POST');

        $headers = $request->getHeaders();
        $headers->addHeaderLine('Accept', 'application/json');

        $this->dispatch('/rtmp/event');
        $this->assertResponseStatusCode(403);

        $this->assertModuleName('rtmp');
        $this->assertControllerName('RTMP\V1\Rpc\Event\Controller');
        $this->assertControllerClass('EventController');
        $this->assertMatchedRouteName('rtmp.rpc.event');
    }
}
