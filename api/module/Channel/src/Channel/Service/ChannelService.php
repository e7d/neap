<?php
namespace Channel\Service;

use Channel\Model\Channel;
use Zend\Db\TableGateway\TableGateway;

class ChannelService
{
    protected $channelTableGateway;

    public function __construct(TableGateway $channelTableGateway)
    {
        $this->channelTableGateway = $channelTableGateway;
    }

    public function fetchAll($params)
    {
        $resultSet = $this->channelTableGateway->select();
        return $resultSet;
    }

    public function fetch($id)
    {
        $rowset = $this->channelTableGateway->select(array('channel_id' => $id));
        $channel = $rowset->current();
        if (!$channel) {
            throw new \Exception("Could not find row $id");
        }
        return $channel;
    }
}
