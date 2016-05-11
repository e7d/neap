<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace IngestTest\V1\Service;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class IngestServiceTest extends AbstractControllerTestCase
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
        $ingestService = $this->serviceManager->get('Ingest\V1\Service\IngestService');

        $this->assertInstanceOf('Ingest\V1\Service\IngestService', $ingestService);
    }

    public function testFetchAll()
    {
        $ingestService = $this->serviceManager->get('Ingest\V1\Service\IngestService');

        $ingestCollection = $ingestService->fetchAll();

        $this->assertInstanceOf('Ingest\V1\Rest\Ingest\IngestCollection', $ingestCollection);
        $this->assertTrue(0 < $ingestCollection->getTotalItemCount());

        $ingestEntity = $ingestCollection->getCurrentItems()->current();

        $this->assertInstanceOf('ZF\Hal\Entity', $ingestEntity);
    }

    public function testFetch()
    {
        $ingestService = $this->serviceManager->get('Ingest\V1\Service\IngestService');

        $ingestId = 'c3aae4dc-dd8d-4e81-a151-7ba30cec1b4a'; // neap ingest id
        $ingestEntity = $ingestService->fetch($ingestId);

        $this->assertInstanceOf('ZF\Hal\Entity', $ingestEntity);
        $this->assertEquals($ingestId, $ingestEntity->entity->ingest_id);
    }

    public function testFetchInvalidIngest()
    {
        $ingestService = $this->serviceManager->get('Ingest\V1\Service\IngestService');

        $ingestId = '00000000-0000-0000-0000-000000000000'; // Invalid ingest id
        $ingestEntity = $ingestService->fetch($ingestId);

        $this->assertNull($ingestEntity);
    }

    public function testFetchOutages()
    {
        $ingestService = $this->serviceManager->get('Ingest\V1\Service\IngestService');

        $ingestId = 'c3aae4dc-dd8d-4e81-a151-7ba30cec1b4a'; // neap ingest id
        $followCollection = $ingestService->fetchOutages(array(
            'ingest_id' => $ingestId
        ));

        $this->assertInstanceOf('Ingest\V1\Rest\Outage\OutageCollection', $followCollection);
    }
}
