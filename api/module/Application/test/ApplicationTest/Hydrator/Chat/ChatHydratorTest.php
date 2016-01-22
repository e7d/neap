<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Hydrator\Chat;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class ChatHydratorTest extends AbstractControllerTestCase
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
        $chatHydrator = $this->serviceManager->get('Application\Hydrator\Chat\ChatHydrator');

        $this->assertInstanceOf('Application\Hydrator\Chat\ChatHydrator', $chatHydrator);
    }

    public function testBuildEntity()
    {
        $chatModel = $this->serviceManager->get('Application\Database\Chat\ChatModel');

        // Test buildEntity without params

        $chatHydrator = $this->serviceManager->get('Application\Hydrator\Chat\ChatHydrator');
        $chat = $chatModel->fetch('f598d270-281b-40c9-a2d8-eb35b56e9412');
        $chatEntity = $chatHydrator->buildEntity($chat);

        $this->assertInstanceOf('ZF\Hal\Entity', $chatEntity);
        $this->assertInstanceOf('ZF\Hal\Link\Link', $chatEntity->getLinks()->get('self'));

        // Test buildEntity with 'embedChannel' param

        $chatHydrator = $this->serviceManager->get('Application\Hydrator\Chat\ChatHydrator');
        $chat = $chatModel->fetch('f598d270-281b-40c9-a2d8-eb35b56e9412');
        $chatHydrator->setParam('embedChannel');
        $chatEntity = $chatHydrator->buildEntity($chat);

        $this->assertFalse(array_key_exists('channel_id', $chatEntity->entity));
        $this->assertInstanceOf('ZF\Hal\Entity', $chatEntity->entity['channel']);

        // Test buildEntity with 'embedUser' param

        $chatHydrator = $this->serviceManager->get('Application\Hydrator\Chat\ChatHydrator');
        $chat = $chatModel->fetch('f598d270-281b-40c9-a2d8-eb35b56e9412');
        $chatHydrator->setParam('embedUser');
        $chatEntity = $chatHydrator->buildEntity($chat);

        $this->assertFalse(array_key_exists('user_id', $chatEntity->entity));
        $this->assertInstanceOf('ZF\Hal\Entity', $chatEntity->entity['user']);

        // Test buildEntity with 'linkChannel' param

        $chatHydrator = $this->serviceManager->get('Application\Hydrator\Chat\ChatHydrator');
        $chat = $chatModel->fetch('f598d270-281b-40c9-a2d8-eb35b56e9412');
        $chatHydrator->setParam('linkChannel');
        $chatEntity = $chatHydrator->buildEntity($chat);

        $this->assertFalse(array_key_exists('channel_id', $chatEntity->entity));
        $this->assertInstanceOf('ZF\Hal\Entity', $chatEntity->entity['channel']);
    }
}
