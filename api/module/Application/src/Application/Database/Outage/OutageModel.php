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

/**
 * OutageModel
 */
class OutageModel extends AbstractModel
{
    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param string $outageId
     *
     * @return Outage|null
     */
    public function fetch(string $outageId)
    {
        $resultSet = $this->tableGateway->select(array('outage_id' => $outageId));
        $outage = $resultSet->current();
        if (!$outage) {
            return null;
        }

        return $outage;
    }

    /**
     * @param string $ingestId
     *
     * @return Select
     */
    public function selectByIngest(string $ingestId)
    {
        $where = new Where();
        $where->equalTo('outage.ingest_id', $ingestId);

        $select = $this->tableGateway->getSql()->select();
        $select->where($where);

        return $select;
    }

    /**
     * @param string $ingestId
     *
     * @return Outage|null
     */
    public function fetchByIngest($ingestId)
    {
        return $this->selectOne(
            $this->selectByIngest($ingestId)
        );
    }
}
