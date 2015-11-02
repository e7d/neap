<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Channel\Service;

use Application\Database\Channel\Channel;
use Application\Database\Follow\Follow;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
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
    protected $userHydrator;

    public function __construct($channelModel, $channelHydrator, $followModel, $followHydrator, $userModel, $userHydrator)
    {
        $this->channelModel = $channelModel;
        $this->channelHydrator = $channelHydrator;
        $this->followModel = $followModel;
        $this->followHydrator = $followHydrator;
        $this->userModel = $userModel;
        $this->userHydrator = $userHydrator;
    }

    public function fetchAll($params, $paginated = true)
    {
        if ($paginated) {
            $select = new Select('channel');

            $this->channelHydrator->setParam('linkUser');
            $this->channelHydrator->setParam('linkChat');

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

        $this->channelHydrator->setParam('embedUser');
        $this->channelHydrator->setParam('linkChat');

        return $this->channelHydrator->buildEntity($channel);
    }

    public function fetchByUser($userId)
    {
        $channel = $this->channelModel->fetchByUser($userId);
        if (!$channel) {
            return null;
        }

        $this->channelHydrator->setParam('embedUser');
        $this->channelHydrator->setParam('linkChat');

        return $this->channelHydrator->buildEntity($channel);
    }

    public function fetchFollowers($params, $paginated = true)
    {
        if ($paginated) {
            $where = new Where();
            $where->equalTo('follow.channel_id', $params['channel_id']);

            $select = new Select('follow');
            $select->where($where);

            $this->followHydrator->setParam('linkChannel');
            $this->followHydrator->setParam('embedUser');

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

        $resultSet = $this->followModel->tableGateway->select();
        return $resultSet;
    }

    public function fetchFollower($id)
    {
        $follow = $this->followModel->fetchByUser($id);
        if (!$follow) {
            return null;
        }

        $this->followHydrator->setParam('embedChannel');
        $this->followHydrator->setParam('embedUser');

        return $this->followHydrator->buildEntity($follow);
    }
}
