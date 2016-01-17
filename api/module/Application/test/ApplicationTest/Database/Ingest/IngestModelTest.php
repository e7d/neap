<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Database\Ingest;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class IngestModelTest extends AbstractControllerTestCase
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
        $ingestModel = $this->serviceManager->get('Application\Database\Ingest\IngestModel');

        $this->assertInstanceOf('Application\Database\Ingest\IngestModel', $ingestModel);
    }

    public function testGetTableGateway()
    {
        $ingestModel = $this->serviceManager->get('Application\Database\Ingest\IngestModel');

        $tableGateway = $ingestModel->getTableGateway();
        $this->assertInstanceOf('Zend\Db\TableGateway\TableGateway', $tableGateway);
    }

    public function testFetch()
    {
        $ingestModel = $this->serviceManager->get('Application\Database\Ingest\IngestModel');

        $ingestId = 'c3aae4dc-dd8d-4e81-a151-7ba30cec1b4a'; // neap ingest id
        $ingest = $ingestModel->fetch($ingestId);
        $this->assertInstanceOf('Application\Database\Ingest\Ingest', $ingest);
        $this->assertEquals($ingestId, $ingest->id);

        $ingestId = '00000000-0000-0000-0000-000000000000'; // Invalid ingest id
        $ingest = $ingestModel->fetch($ingestId);
        $this->assertNull($ingest);
    }

    public function testFetchByHostname()
    {
        $ingestModel = $this->serviceManager->get('Application\Database\Ingest\IngestModel');

        $ingestId = 'c3aae4dc-dd8d-4e81-a151-7ba30cec1b4a'; // neap ingest id
        $hostname = 'rtmp.neap.dev'; // neap ingest hostname
        $ingest = $ingestModel->fetchByHostname($hostname);
        $this->assertInstanceOf('Application\Database\Ingest\Ingest', $ingest);
        $this->assertEquals($ingestId, $ingest->id);

        $hostname = 'invalid.host.name'; // Invalid hostname
        $ingest = $ingestModel->fetchByHostname($hostname);
        $this->assertNull($ingest);
    }
}
