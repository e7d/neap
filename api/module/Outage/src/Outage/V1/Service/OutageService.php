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

namespace Outage\V1\Service;

use Application\Database\Outage\Outage;
use Outage\V1\Rest\Outage\OutageCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbSelect;

class OutageService
{
    private $serviceManager;

    public function __construct($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function fetchAll($params = [])
    {
        $outageModel = $this->serviceManager->get('Application\Database\Outage\OutageModel');
        $outageHydrator = $this->serviceManager->get('Application\Hydrator\Outage\OutageHydrator');

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
        $outageModel = $this->serviceManager->get('Application\Database\Outage\OutageModel');
        $outageHydrator = $this->serviceManager->get('Application\Hydrator\Outage\OutageHydrator');

        $outage = $outageModel->fetch($outageId);
        if (!$outage) {
            return null;
        }

        return $outageHydrator->buildEntity($outage);
    }
}
