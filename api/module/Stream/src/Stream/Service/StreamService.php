<?php
namespace Stream\Service;

use Stream\Model\Stream;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class StreamService
{
    protected $hydratorService;
    protected $tableGateway;
    protected $channelService;
    protected $userService;

    public function __construct(TableGateway $tableGateway, $channelService, $userService)
    {
        $this->hydratorService = new StreamHydratorService(
            $channelService,
            $userService
        );
        $this->tableGateway = $tableGateway;
        $this->channelService = $channelService;
        $this->userService = $userService;
    }

    public function fetchAll($params, $paginated = true)
    {
        if ($paginated) {
            $select = new Select('stream');

            $this->hydratorService->setParam("isCollection", true);
            $hydratingResultSet = new HydratingResultSet(
                $this->hydratorService,
                new Stream()
            );

            $paginatorAdapter = new DbSelect(
                $select,
                $this->tableGateway->getAdapter(),
                $hydratingResultSet
            );

            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }

        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function fetch($id)
    {
        $rowset = $this->tableGateway->select(array('stream_id' => $id));
        $stream = $rowset->current();
        if (!$stream) {
            return null;
        }

        return $this->hydratorService->buildEntity($stream);
    }

    public function fetchByUser($userId)
    {
        $where = new Where();
        $where->equalTo('user.user_id', $userId);

        $sqlSelect = $this->tableGateway->getSql()->select()->where($where);
        $sqlSelect->join('channel', 'channel.channel_id = stream.channel_id', array(), 'left');
        $sqlSelect->join('user', 'user.user_id = channel.user_id', array(), 'left');

        $rowset = $this->tableGateway->selectWith($sqlSelect);
        $stream = $rowset->current();
        if (!$stream) {
            return null;
        }

        return $stream;
    }
}
