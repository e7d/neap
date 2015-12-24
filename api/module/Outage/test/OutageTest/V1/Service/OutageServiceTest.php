<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace OutageTest\V1\Service;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class OutageServiceTest extends AbstractHttpControllerTestCase
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
        $outageService = $this->serviceManager->get('Outage\V1\Service\OutageService');

        $this->assertEquals('Outage\V1\Service\OutageService', get_class($outageService));
    }
}
