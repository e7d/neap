<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database;

use Zend\Db\ResultSet\ResultSetInterface;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

/**
 * Defines base behavior for any Model
 */
abstract class AbstractModel
{
    /**
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     * @return TableGateway
     */
    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    /**
     * @return Select
     */
    public function getSqlSelect()
    {
        return $this->tableGateway->getSql()->select();
    }

    /**
     * @param Select $select
     *
     * @return null|ResultSetInterface
     *
     * @throws \RuntimeException
     */
    public function selectAll(Select $select)
    {
        return $this->tableGateway->selectWith($select);
    }

    /**
     * @param Select $select
     *
     * @return array|\ArrayObject|null
     */
    public function selectOne(Select $select)
    {
        $resultSet = $this->selectAll($select);
        $firstRow = $resultSet->current();
        if (!$firstRow) {
            return null;
        }

        return $firstRow;
    }
}
