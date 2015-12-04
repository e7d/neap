<?php
namespace Stream\Service;

use Stream\Model\Stream;
use Zend\Db\TableGateway\TableGateway;

class StreamService
{
    protected $streamTableGateway;
    protected $streamOwnerTableGateway;

    public function __construct(TableGateway $streamTableGateway, TableGateway $streamOwnerTableGateway)
    {
        $this->streamTableGateway = $streamTableGateway;
        $this->streamOwnerTableGateway = $streamOwnerTableGateway;
    }

    public function fetchAll($params)
    {
        $resultSet = $this->streamTableGateway->select();
        return $resultSet;
    }

    public function fetch($id)
    {
        $rowset = $this->streamTableGateway->select(array('stream_id' => $id));
        $stream = $rowset->current();
        if (!$stream) {
            return null;
        }

        return $stream;
    }

    public function fetchOwner($id)
    {
        $rowset = $this->streamOwnerTableGateway->select(array('stream_id' => $id));
        $streamOwner = $rowset->current();
        if (!$streamOwner) {
            return null;
        }

        return $streamOwner;
    }
}
