<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Ingest;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class IngestModel extends AbstractModel
{
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetch($ingestId)
    {
        $resultSet = $this->tableGateway->select(array('ingest_id' => $ingestId));
        $ingest = $resultSet->current();
        if (!$ingest) {
            return null;
        }

        return $ingest;
    }

    public function selectByHostname($hostname)
    {
        $where = new Where();
        $where->equalTo('ingest.hostname', $hostname);

        $select = $this->tableGateway->getSql()->select();
        $select->where($where);

        return $select;
    }

    public function fetchByHostname($hostname)
    {
        return $this->selectOne(
            $this->selectByHostname($hostname)
        );
    }
}
