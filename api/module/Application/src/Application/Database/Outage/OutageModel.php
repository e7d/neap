<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Outage;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class OutageModel extends AbstractModel
{
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetch($outageId)
    {
        $resultSet = $this->tableGateway->select(array('outage_id' => $outageId));
        $outage = $resultSet->current();
        if (!$outage) {
            return null;
        }

        return $outage;
    }

    public function selectByIngest($ingestId)
    {
        $where = new Where();
        $where->equalTo('outage.ingest_id', $ingestId);

        $select = $this->tableGateway->getSql()->select();
        $select->where($where);

        return $select;
    }

    public function fetchByIngest($ingestId)
    {
        return $this->selectOne(
            $this->selectByIngest($ingestId)
        );
    }
}
