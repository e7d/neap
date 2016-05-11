<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace TopicTest\V1\Service;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class TopicServiceTest extends AbstractControllerTestCase
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
        $topicService = $this->serviceManager->get('Topic\V1\Service\TopicService');

        $this->assertInstanceOf('Topic\V1\Service\TopicService', $topicService);
    }

    public function testFetchAll()
    {
        $topicService = $this->serviceManager->get('Topic\V1\Service\TopicService');

        $topicCollection = $topicService->fetchAll();

        $this->assertInstanceOf('Topic\V1\Rest\Topic\TopicCollection', $topicCollection);
        $this->assertTrue(0 < $topicCollection->getTotalItemCount());

        $topicEntity = $topicCollection->getCurrentItems()->current();

        $this->assertInstanceOf('ZF\Hal\Entity', $topicEntity);

        $params = array(
            'top' =>true
        );
        $topicCollection = $topicService->fetchAll($params);

        $this->assertInstanceOf('Topic\V1\Rest\Topic\TopicCollection', $topicCollection);
        $this->assertTrue(0 < $topicCollection->getTotalItemCount());
    }

    public function testFetch()
    {
        $topicService = $this->serviceManager->get('Topic\V1\Service\TopicService');

        $topicId = '0a686e36-f1a5-4829-8fc3-3f885dc1ec28'; // Video games topic id
        $topicEntity = $topicService->fetch($topicId);

        $this->assertInstanceOf('ZF\Hal\Entity', $topicEntity);
        $this->assertEquals($topicId, $topicEntity->entity->topic_id);
    }

    public function testFetchInvalidTopic()
    {
        $topicService = $this->serviceManager->get('Topic\V1\Service\TopicService');

        $topicId = '00000000-0000-0000-0000-000000000000'; // Invalid topic id
        $topicEntity = $topicService->fetch($topicId);

        $this->assertNull($topicEntity);
    }
}
