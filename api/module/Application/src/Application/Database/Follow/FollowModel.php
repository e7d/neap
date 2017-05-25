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

namespace Application\Database\Follow;

use Application\Database\AbstractModel;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

/**
 * FollowModel
 */
class FollowModel extends AbstractModel
{
    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param string $userId
     *
     * @return Select
     */
    public function selectByUser(string $userId)
    {
        $where = new Where();
        $where->equalTo('follow.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->where($where);

        return $select;
    }

    /**
     * @param string $userId
     *
     * @return ResultSet
     */
    public function fetchByUser($userId)
    {
        return $this->selectAll(
            $this->selectByUser($userId)
        );
    }
}
