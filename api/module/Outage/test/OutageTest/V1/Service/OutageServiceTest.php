<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace OutageTest\V1\Service;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class OutageServiceTest extends AbstractControllerTestCase
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
        $outageService = $this->serviceManager->get('Outage\V1\Service\OutageService');

        $this->assertInstanceOf('Outage\V1\Service\OutageService', $outageService);
    }

    public function testFetchAll()
    {
        $outageService = $this->serviceManager->get('Outage\V1\Service\OutageService');

        $outageCollection = $outageService->fetchAll();

        $this->assertInstanceOf('Outage\V1\Rest\Outage\OutageCollection', $outageCollection);
        $this->assertTrue(0 < $outageCollection->getTotalItemCount());

        $outageEntity = $outageCollection->getCurrentItems()->current();

        $this->assertInstanceOf('ZF\Hal\Entity', $outageEntity);
    }

    public function testFetch()
    {
        $outageService = $this->serviceManager->get('Outage\V1\Service\OutageService');

        $outageId = '2c8132bc-479a-4dbb-99a4-773fa451b27b'; // neapi ngest first outage id
        $outageEntity = $outageService->fetch($outageId);

        $this->assertInstanceOf('ZF\Hal\Entity', $outageEntity);
        $this->assertEquals($outageId, $outageEntity->entity->outage_id);
    }

    public function testFetchInvalidOutage()
    {
        $outageService = $this->serviceManager->get('Outage\V1\Service\OutageService');

        $outageId = '00000000-0000-0000-0000-000000000000'; // Invalid outage id
        $outageEntity = $outageService->fetch($outageId);

        $this->assertNull($outageEntity);
    }
}
