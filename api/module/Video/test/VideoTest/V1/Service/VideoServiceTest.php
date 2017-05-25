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

namespace VideoTest\V1\Service;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class VideoServiceTest extends AbstractControllerTestCase
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
        $videoService = $this->serviceManager->get('Video\V1\Service\VideoService');

        $this->assertInstanceOf('Video\V1\Service\VideoService', $videoService);
    }

    public function testFetchAll()
    {
        $videoService = $this->serviceManager->get('Video\V1\Service\VideoService');

        $videoCollection = $videoService->fetchAll();

        $this->assertInstanceOf('Video\V1\Rest\Video\VideoCollection', $videoCollection);
        $this->assertTrue(0 < $videoCollection->getTotalItemCount());

        $videoEntity = $videoCollection->getCurrentItems()->current();

        $this->assertInstanceOf('ZF\Hal\Entity', $videoEntity);
    }

    public function testFetch()
    {
        $videoService = $this->serviceManager->get('Video\V1\Service\VideoService');

        $videoId = '2be039b2-f04c-4f6c-82aa-11aed1465f1a'; // Jax's History video id
        $videoEntity = $videoService->fetch($videoId);

        $this->assertInstanceOf('ZF\Hal\Entity', $videoEntity);
        $this->assertEquals($videoId, $videoEntity->entity->video_id);
    }

    public function testFetchInvalidVideo()
    {
        $videoService = $this->serviceManager->get('Video\V1\Service\VideoService');

        $videoId = '00000000-0000-0000-0000-000000000000'; // Invalid video id
        $videoEntity = $videoService->fetch($videoId);

        $this->assertNull($videoEntity);
    }
}
