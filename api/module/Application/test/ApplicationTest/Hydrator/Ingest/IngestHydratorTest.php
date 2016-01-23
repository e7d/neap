<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Hydrator\Ingest;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class IngestHydratorTest extends AbstractControllerTestCase
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
        $ingestHydrator = $this->serviceManager->get('Application\Hydrator\Ingest\IngestHydrator');

        $this->assertInstanceOf('Application\Hydrator\Ingest\IngestHydrator', $ingestHydrator);
    }

    public function testBuildEntity()
    {
        $ingestHydrator = $this->serviceManager->get('Application\Hydrator\Ingest\IngestHydrator');
        $ingestModel = $this->serviceManager->get('Application\Database\Ingest\IngestModel');

        $ingestId = 'c3aae4dc-dd8d-4e81-a151-7ba30cec1b4a'; // Neap ingest id
        $ingest = $ingestModel->fetch($ingestId);
        $ingestEntity = $ingestHydrator->buildEntity($ingest);

        $this->assertInstanceOf('ZF\Hal\Entity', $ingestEntity);
        $this->assertInstanceOf('ZF\Hal\Link\Link', $ingestEntity->getLinks()->get('self'));
    }

    public function testBuildEntityWithLinkOutages()
    {
        $ingestHydrator = $this->serviceManager->get('Application\Hydrator\Ingest\IngestHydrator');
        $ingestModel = $this->serviceManager->get('Application\Database\Ingest\IngestModel');

        $ingestId = 'c3aae4dc-dd8d-4e81-a151-7ba30cec1b4a'; // Neap ingest id
        $ingest = $ingestModel->fetch($ingestId);
        $ingestHydrator->setParam('linkOutages');
        $ingestEntity = $ingestHydrator->buildEntity($ingest);

        $this->assertInstanceOf('ZF\Hal\Link\Link', $ingestEntity->getLinks()->get('outages'));
    }
}
