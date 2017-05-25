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

use Application\Database\User\User;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class IdentityServiceTest extends AbstractControllerTestCase
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
        $identityService = $this->serviceManager->get('Application\Authorization\IdentityService');

        $this->assertInstanceOf('Application\Authorization\IdentityService', $identityService);
    }

    public function testSetAndGetIdentity()
    {
        $identityService = $this->serviceManager->get('Application\Authorization\IdentityService');

        $identity = new User();
        $identityService->setIdentity($identity);
        $this->assertEquals($identity, $identityService->getIdentity());
    }
}
