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

namespace Ingest\V1\Service;

use Application\Database\Ingest\Ingest;
use Application\Database\Outage\Outage;
use Ingest\V1\Rest\Ingest\IngestCollection;
use Ingest\V1\Rest\Outage\OutageCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbSelect;

class IngestService
{
    private $serviceManager;

    public function __construct($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function fetchAll($params = [])
    {
        $ingestModel = $this->serviceManager->get('Application\Database\Ingest\IngestModel');
        $ingestHydrator = $this->serviceManager->get('Application\Hydrator\Ingest\IngestHydrator');

        $select = $ingestModel->getSqlSelect();

        $ingestHydrator->setParam('linkOutages', true);

        $hydratingResultSet = new HydratingResultSet(
            $ingestHydrator,
            new Ingest()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $ingestModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new IngestCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($ingestId)
    {
        $ingestModel = $this->serviceManager->get('Application\Database\Ingest\IngestModel');
        $ingestHydrator = $this->serviceManager->get('Application\Hydrator\Ingest\IngestHydrator');

        $ingest = $ingestModel->fetch($ingestId);
        if (!$ingest) {
            return null;
        }

        $ingestHydrator->setParam('linkOutages', true);

        return $ingestHydrator->buildEntity($ingest);
    }

    public function fetchOutages($params)
    {
        $outageModel = $this->serviceManager->get('Application\Database\Outage\OutageModel');
        $outageHydrator = $this->serviceManager->get('Application\Hydrator\Outage\OutageHydrator');

        $select = $outageModel->selectByIngest($params['ingest_id']);

        $hydratingResultSet = new HydratingResultSet(
            $outageHydrator,
            new Outage()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $outageModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new OutageCollection($paginatorAdapter);
        return $collection;
    }
}
