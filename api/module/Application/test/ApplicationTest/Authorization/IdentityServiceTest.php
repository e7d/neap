<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
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
