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

namespace ApplicationTest\Authorization;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class LocalhostControllerTest extends AbstractControllerTestCase
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
        $localhostController = $this->serviceManager->get('Application\Authorization\LocalhostController');

        $this->assertInstanceOf('Application\Authorization\LocalhostController', $localhostController);
    }

    public function testInvalidRemoteAddress()
    {
        $localhostController = $this->serviceManager->get('Application\Authorization\LocalhostController');

        $this->setExpectedException('DomainException');

        $_SERVER['REMOTE_ADDR'] = '8.8.8.8';
        $localhostController->assertLocalConnection();
    }
}
