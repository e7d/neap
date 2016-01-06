<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Outage\V1\Service;
use Application\Database\Outage\Outage;
use Outage\V1\Rest\Outage\OutageCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;

class OutageService
{
    protected $outageModel;
    protected $outageHydrator;

    public function __construct($outageModel, $outageHydrator)
    {
        $this->outageModel = $outageModel;
        $this->outageHydrator = $outageHydrator;
    }

    public function fetchAll($params)
    {
        $select = new Select('outage');

        $this->outageHydrator->setParam('linkIngest');

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

    public function fetch($id)
    {
        $outage = $this->outageModel->fetch($id);
        if (!$outage) {
            return null;
        }

        return $this->outageHydrator->buildEntity($outage);
    }
}
