<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Chat;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

/**
 * ChatModel
 */
class ChatModel extends AbstractModel
{
    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param string $chatId
     *
     * @return Chat|null
     */
    public function fetch(string $chatId)
    {
        $resultSet = $this->tableGateway->select(array('chat_id' => $chatId));
        $chat = $resultSet->current();
        if (!$chat) {
            return null;
        }

        return $chat;
    }

    /**
     * @param string $channelId
     *
     * @return Select
     */
    public function selectByChannel(string $channelId)
    {
        $where = new Where();
        $where->equalTo('chat.channel_id', $channelId);

        $select = $this->tableGateway->getSql()->select();
        $select->where($where);

        return $select;
    }

    /**
     * @param string $channelId
     *
     * @return Chat|null
     */
    public function fetchByChannel(string $channelId)
    {
        return $this->selectOne(
            $this->selectByChannel($channelId)
        );
    }
    /**
     * @param string $userId
     *
     * @return Select
     */
    public function selectModsByUser(string $userId)
    {
        $where = new Where();
        $where->equalTo('mod.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('mod', 'mod.chat_id = chat.chat_id', array(), 'inner');
        $select->where($where);

        return $select;
    }
}
