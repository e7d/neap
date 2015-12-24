<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace StreamTest\V1\Service;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class StreamServiceTest extends AbstractHttpControllerTestCase
{
    private $serviceManager;

    public function setUp()
    {
        $this->setApplicationConfig(
            include './config/application.config.php'
        );
        parent::setUp();
        $this->serviceManager = $this->getApplicationServiceLocator();
        $this->serviceManager->setAllowOverride(true);
    }

    public function testClassType()
    {
        $streamService = $this->serviceManager->get('Stream\V1\Service\StreamService');

        $this->assertEquals('Stream\V1\Service\StreamService', get_class($streamService));
    }
}
