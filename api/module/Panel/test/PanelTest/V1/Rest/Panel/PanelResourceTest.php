<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace PanelTest\V1\Rest\Panel;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class PanelResourceTest extends AbstractControllerTestCase
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
        $panelResource = $this->serviceManager->get('Panel\V1\Rest\Panel\PanelResource');

        $this->assertInstanceOf('Panel\V1\Rest\Panel\PanelResource', $panelResource);
    }
}
