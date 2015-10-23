<?php
namespace Channel\Service;

use Application\Database\Channel\Channel;
use Application\Database\Follow\Follow;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ChannelService
{
    protected $channelModel;
    protected $channelHydrator;
    protected $followModel;
    protected $followHydrator;
    protected $userModel;

    public function __construct($channelModel, $channelHydrator, $followModel, $followHydrator, $userModel)
    {
        $this->channelModel = $channelModel;
        $this->channelHydrator = $channelHydrator;
        $this->followModel = $followModel;
        $this->followHydrator = $followHydrator;
        $this->userModel = $userModel;
    }

    public function fetchAll($params, $paginated = true)
    {
        if ($paginated) {
            $select = new Select('channel');

            $this->channelHydrator->setParam("isCollection", true);
            $hydratingResultSet = new HydratingResultSet(
                $this->channelHydrator,
                new Channel()
            );

            $paginatorAdapter = new DbSelect(
                $select,
                $this->channelModel->tableGateway->getAdapter(),
                $hydratingResultSet
            );

            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }

        $resultSet = $this->channelModel->tableGateway->select();
        return $resultSet;
    }

    public function fetch($id)
    {
        $channel = $this->channelModel->fetch($id);
        if (!$channel) {
            return null;
        }

        return $this->channelHydrator->buildEntity($channel);
    }

    public function fetchFollowers($params, $paginated = true)
    {
        if ($paginated) {
            $select = new Select('follow');

            $this->followHydrator->setParam("isCollection", true);
            $hydratingResultSet = new HydratingResultSet(
                $this->followHydrator,
                new Follow()
            );

            $paginatorAdapter = new DbSelect(
                $select,
                $this->followModel->tableGateway->getAdapter(),
                $hydratingResultSet
            );

            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }

        $resultSet = $this->channelModel->tableGateway->select();
        return $resultSet;
    }

    public function fetchByUser($userId)
    {
        return $this->channelModel->fetchByUser($userId);
    }
}
