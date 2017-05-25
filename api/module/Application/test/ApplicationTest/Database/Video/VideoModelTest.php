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

namespace ApplicationTest\Database\Video;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class VideoModelTest extends AbstractControllerTestCase
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
        $videoModel = $this->serviceManager->get('Application\Database\Video\VideoModel');

        $this->assertInstanceOf('Application\Database\Video\VideoModel', $videoModel);
    }

    public function testGetTableGateway()
    {
        $videoModel = $this->serviceManager->get('Application\Database\Video\VideoModel');

        $tableGateway = $videoModel->getTableGateway();
        $this->assertInstanceOf('Zend\Db\TableGateway\TableGateway', $tableGateway);
    }

    public function testGetSqlSelect()
    {
        $videoModel = $this->serviceManager->get('Application\Database\Video\VideoModel');
        $select = $videoModel->getSqlSelect();

        $this->assertInstanceOf('Zend\Db\Sql\Select', $select);
        $this->assertEquals('SELECT "video".* FROM "video"', $select->getSqlString());
    }

    public function testFetch()
    {
        $videoModel = $this->serviceManager->get('Application\Database\Video\VideoModel');

        $videoId = '2be039b2-f04c-4f6c-82aa-11aed1465f1a'; // Jax video id
        $video = $videoModel->fetch($videoId);
        $this->assertInstanceOf('Application\Database\Video\Video', $video);
        $this->assertEquals($videoId, $video->video_id);

        $videoId = '00000000-0000-0000-0000-000000000000'; // Invalid video id
        $video = $videoModel->fetch($videoId);
        $this->assertNull($video);
    }

    public function testFetchByUser()
    {
        $videoModel = $this->serviceManager->get('Application\Database\Video\VideoModel');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $videos = $videoModel->fetchByUser($userId);
        $this->assertInstanceOf('Zend\Db\ResultSet\ResultSet', $videos);
        $this->assertTrue(0 < $videos->count());

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $videos = $videoModel->fetchByUser($userId);
        $this->assertInstanceOf('Zend\Db\ResultSet\ResultSet', $videos);
        $this->assertEquals(0, $videos->count());
    }
}
