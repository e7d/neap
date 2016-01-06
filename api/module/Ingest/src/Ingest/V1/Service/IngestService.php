<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Ingest\V1\Service;
use Application\Database\Ingest\Ingest;
use Application\Database\Outage\Outage;
use Ingest\V1\Rest\Ingest\IngestCollection;
use Ingest\V1\Rest\Outage\OutageCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;

class IngestService
{
    protected $ingestModel;
    protected $ingestHydrator;
    protected $outageModel;
    protected $outageHydrator;

    public function __construct($ingestModel, $ingestHydrator, $outageModel, $outageHydrator)
    {
        $this->ingestModel = $ingestModel;
        $this->ingestHydrator = $ingestHydrator;
        $this->outageModel = $outageModel;
        $this->outageHydrator = $outageHydrator;
    }

    public function fetchAll($params)
    {
        $select = new Select('ingest');

        $this->ingestHydrator->setParam('linkOutages');

        $hydratingResultSet = new HydratingResultSet(
            $this->ingestHydrator,
            new Ingest()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->ingestModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new IngestCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $ingest = $this->ingestModel->fetch($id);
        if (!$ingest) {
            return null;
        }

        $this->ingestHydrator->setParam('linkOutages');

        return $this->ingestHydrator->buildEntity($ingest);
    }

    public function fetchOutages($params)
    {
        $where = new Where();
        $where->equalTo('outage.ingest_id', $params['ingest_id']);

        $select = new Select('outage');
        $select->where($where);

        $hydratingResultSet = new HydratingResultSet(
            $this->outageHydrator,
            new Outage()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->outageModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new OutageCollection($paginatorAdapter);
        return $collection;
    }
}
