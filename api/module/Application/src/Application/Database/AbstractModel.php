<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database;

abstract class AbstractModel
{
    protected $tableGateway;

    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    public function getSqlSelect()
    {
        return $this->tableGateway->getSql()->select();
    }

    public function selectAll($select)
    {
        return $this->tableGateway->selectWith($select);
    }

    public function selectOne($select)
    {
        $resultSet = $this->selectAll($select);
        $firstRow = $resultSet->current();
        if (!$firstRow) {
            return null;
        }

        return $firstRow;
    }
}
