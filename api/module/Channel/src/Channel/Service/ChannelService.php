<?php
namespace Channel\Service;

use Application\Database\Channel\Channel;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class ChannelService
{
    protected $hydrator;
    protected $channelModel;
    protected $userModel;

    public function __construct($hydrator, $channelModel, $userModel)
    {
        $this->hydrator = $hydrator;
        $this->channelModel = $channelModel;
        $this->userModel = $userModel;
    }

    public function fetchAll($params, $paginated = true)
    {
        if ($paginated) {
            $select = new Select('channel');

            $this->hydrator->setParam("isCollection", true);
            $hydratingResultSet = new HydratingResultSet(
                $this->hydrator,
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

        return $this->hydrator->buildEntity($channel);
    }

    public function fetchByUser($userId)
    {
        return $this->channelModel->fetchByUser($userId);
    }
}
