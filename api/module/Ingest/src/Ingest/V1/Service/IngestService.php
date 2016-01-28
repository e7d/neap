<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
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
    private $services;

    public function __construct($services)
    {
        $this->services = $services;
    }

    public function fetchAll($params = [])
    {
        $ingestModel = $this->services->get('Application\Database\Ingest\IngestModel');
        $ingestHydrator = $this->services->get('Application\Hydrator\Ingest\IngestHydrator');

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
        $ingestModel = $this->services->get('Application\Database\Ingest\IngestModel');
        $ingestHydrator = $this->services->get('Application\Hydrator\Ingest\IngestHydrator');

        $ingest = $ingestModel->fetch($ingestId);
        if (!$ingest) {
            return null;
        }

        $ingestHydrator->setParam('linkOutages', true);

        return $ingestHydrator->buildEntity($ingest);
    }

    public function fetchOutages($params)
    {
        $outageModel = $this->services->get('Application\Database\Outage\OutageModel');
        $outageHydrator = $this->services->get('Application\Hydrator\Outage\OutageHydrator');

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
