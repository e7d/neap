<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Outage;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class OutageModel
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    public function fetch($outageId)
    {
        $rowset = $this->tableGateway->select(array('outage_id' => $outageId));
        $outage = $rowset->current();
        if (!$outage) {
            return null;
        }

        return $outage;
    }
}
