<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Database\Outage;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class OutageModelTest extends AbstractControllerTestCase
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
        $outageModel = $this->serviceManager->get('Application\Database\Outage\OutageModel');

        $this->assertInstanceOf('Application\Database\Outage\OutageModel', $outageModel);
    }

    public function testGetTableGateway()
    {
        $outageModel = $this->serviceManager->get('Application\Database\Outage\OutageModel');

        $tableGateway = $outageModel->getTableGateway();
        $this->assertInstanceOf('Zend\Db\TableGateway\TableGateway', $tableGateway);
    }

    public function testFetch()
    {
        $outageModel = $this->serviceManager->get('Application\Database\Outage\OutageModel');

        $outageId = '337786b3-2784-49cc-ac28-83604eda96fa'; // Valid outage id
        $outage = $outageModel->fetch($outageId);
        $this->assertInstanceOf('Application\Database\Outage\Outage', $outage);
        $this->assertEquals($outageId, $outage->id);

        $outageId = '00000000-0000-0000-0000-000000000000'; // Invalid outage id
        $outage = $outageModel->fetch($outageId);
        $this->assertNull($outage);
    }
}
