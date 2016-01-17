<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Database\Topic;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class TopicModelTest extends AbstractControllerTestCase
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
        $topicModel = $this->serviceManager->get('Application\Database\Topic\TopicModel');

        $this->assertInstanceOf('Application\Database\Topic\TopicModel', $topicModel);
    }

    public function testGetTableGateway()
    {
        $topicModel = $this->serviceManager->get('Application\Database\Topic\TopicModel');

        $tableGateway = $topicModel->getTableGateway();
        $this->assertInstanceOf('Zend\Db\TableGateway\TableGateway', $tableGateway);
    }

    public function testFetch()
    {
        $topicModel = $this->serviceManager->get('Application\Database\Topic\TopicModel');

        $topicId = '0a686e36-f1a5-4829-8fc3-3f885dc1ec28'; // Video Games topic id
        $topic = $topicModel->fetch($topicId);
        $this->assertInstanceOf('Application\Database\Topic\Topic', $topic);
        $this->assertEquals($topicId, $topic->id);

        $topicId = '00000000-0000-0000-0000-000000000000'; // Invalid topic id
        $topic = $topicModel->fetch($topicId);
        $this->assertNull($topic);
    }
}
