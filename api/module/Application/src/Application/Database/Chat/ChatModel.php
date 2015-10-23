<?php
namespace Application\Database\Chat;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class ChatModel
{
    public $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetch($id)
    {
        $rowset = $this->tableGateway->select(array('chat_id' => $id));
        $chat = $rowset->current();
        if (!$chat) {
            return null;
        }

        return $chat;
    }
}
