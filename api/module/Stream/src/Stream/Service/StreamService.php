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
    protected $streamModel;
    protected $streamHydrator;
    protected $userModel;

    public function __construct($streamModel, $streamHydrator, $userModel)
    {
        $this->streamModel = $streamModel;
        $this->streamHydrator = $streamHydrator;
        $this->userModel = $userModel;
    }

    public function fetchAll($params, $paginated = true)
    {
        if ($paginated) {
            $select = new Select('stream');

            $this->streamHydrator->setParam("isCollection", true);
            $hydratingResultSet = new HydratingResultSet(
                $this->streamHydrator,
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

        return $this->streamHydrator->buildEntity($stream);
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
