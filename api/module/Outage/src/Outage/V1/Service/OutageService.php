<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Outage\V1\Service;

use Application\Database\Outage\Outage;
use Outage\V1\Rest\Outage\OutageCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbSelect;

class OutageService
{
    private $services;

    public function __construct($services)
    {
        $this->services = $services;
    }

    public function fetchAll($params = [])
    {
        $outageModel = $this->services->get('Application\Database\Outage\OutageModel');
        $outageHydrator = $this->services->get('Application\Hydrator\Outage\OutageHydrator');

        $select = $outageModel->getSqlSelect();

        $outageHydrator->setParam('linkIngest', true);

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

    public function fetch($outageId)
    {
        $outageModel = $this->services->get('Application\Database\Outage\OutageModel');
        $outageHydrator = $this->services->get('Application\Hydrator\Outage\OutageHydrator');

        $outage = $outageModel->fetch($outageId);
        if (!$outage) {
            return null;
        }

        return $outageHydrator->buildEntity($outage);
    }
}
