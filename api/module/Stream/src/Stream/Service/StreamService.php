<?php
namespace Stream\Service;

use Application\Database\Stream\Stream;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class StreamService
{
    protected $hydrator;
    protected $streamModel;
    protected $userModel;

    public function __construct($hydrator, $streamModel, $userModel)
    {
        $this->hydrator = $hydrator;
        $this->streamModel = $streamModel;
        $this->userModel = $userModel;
    }

    public function fetchAll($params, $paginated = true)
    {
        if ($paginated) {
            $select = new Select('stream');

            $this->hydrator->setParam("isCollection", true);
            $hydratingResultSet = new HydratingResultSet(
                $this->hydrator,
                new Stream()
            );

            $paginatorAdapter = new DbSelect(
                $select,
                $this->streamModel->tableGateway->getAdapter(),
                $hydratingResultSet
            );

            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }

        $resultSet = $this->streamModel->tableGateway->select();
        return $resultSet;
    }

    public function fetch($id)
    {
        $stream = $this->streamModel->fetch($id);
        if (!$stream) {
            return null;
        }

        return $this->hydrator->buildEntity($stream);
    }

    public function fetchByChannel($channelId)
    {
        return $this->streamModel->fetchByChannel($channelId);
    }

    public function fetchByUser($userId)
    {
        return $this->streamModel->fetchByUser($userId);
    }
}
