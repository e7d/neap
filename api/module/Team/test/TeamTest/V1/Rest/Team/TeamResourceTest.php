<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace TeamTest\V1\Rest\Team;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class TeamResourceTest extends AbstractControllerTestCase
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
        $teamResource = $this->serviceManager->get('Team\V1\Rest\Team\TeamResource');

        $this->assertInstanceOf('Team\V1\Rest\Team\TeamResource', $teamResource);
    }
}
