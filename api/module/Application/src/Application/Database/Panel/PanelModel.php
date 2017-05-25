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

namespace Application\Database\Panel;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

/**
 * PanelModel
 */
class PanelModel extends AbstractModel
{
    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param string $channelId
     *
     * @return Select
     */
    public function selectByChannel(string $channelId)
    {
        $where = new Where();
        $where->equalTo('panel.channel_id', $channelId);

        $select = $this->tableGateway->getSql()->select();
        $select->where($where);

        return $select;
    }
}
