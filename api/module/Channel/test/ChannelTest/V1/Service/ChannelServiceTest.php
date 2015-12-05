<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace ChannelTest\V1\Service;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ChannelServiceTest extends AbstractHttpControllerTestCase
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
        var_dump($this->serviceManager->has('Channel\V1\Service\ChannelService'));

        $channelService = $this->serviceManager->get('Channel\V1\Service\ChannelService');
        
        var_dump($this->serviceManager->get('Channel\V1\Service\ChannelService'));
        die;

        $this->assertEquals('Channel\V1\Service\ChannelService', get_class($channelService));
    }
}
