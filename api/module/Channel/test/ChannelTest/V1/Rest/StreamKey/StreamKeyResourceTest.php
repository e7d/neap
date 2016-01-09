<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ChannelTest\V1\Rest\StreamKey;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class StreamKeyResourceTest extends AbstractHttpControllerTestCase
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
        $channelResource = $this->serviceManager->get('Channel\V1\Rest\StreamKey\StreamKeyResource');

        $this->assertInstanceOf('Channel\V1\Rest\StreamKey\StreamKeyResource', $channelResource);
    }
}
