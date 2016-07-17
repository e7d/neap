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
use Zend\Db\Sql\Select;

/**
 * IngestModel
 */
class IngestModel extends AbstractModel
{
    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param string $ingestId
     *
     * @return Ingest|null
     */
    public function fetch(string $ingestId)
    {
        $resultSet = $this->tableGateway->select(array('ingest_id' => $ingestId));
        $ingest = $resultSet->current();
        if (!$ingest) {
            return null;
        }

        return $ingest;
    }

    /**
     * @param string $hostname
     *
     * @return Select
     */
    public function selectByHostname(string $hostname)
    {
        $where = new Where();
        $where->equalTo('ingest.hostname', $hostname);

        $select = $this->tableGateway->getSql()->select();
        $select->where($where);

        return $select;
    }

    /**
     * @param string $hostname
     *
     * @return Ingest|null
     */
    public function fetchByHostname($hostname)
    {
        return $this->selectOne(
            $this->selectByHostname($hostname)
        );
    }
}
