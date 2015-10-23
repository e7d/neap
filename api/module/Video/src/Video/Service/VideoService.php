<?php
namespace Video\Service;

use Application\Database\Video\Video;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class VideoService
{
    protected $videoModel;
    protected $videoHydrator;
    protected $userModel;

    public function __construct($videoModel, $videoHydrator, $userModel)
    {
        $this->videoModel = $videoModel;
        $this->videoHydrator = $videoHydrator;
        $this->userModel = $userModel;
    }

    public function fetchAll($params, $paginated = true)
    {
        if ($paginated) {
            $select = new Select('video');

            $hydratingResultSet = new HydratingResultSet(
                $this->videoHydrator,
                new Video()
            );

            $paginatorAdapter = new DbSelect(
                $select,
                $this->videoModel->tableGateway->getAdapter(),
                $hydratingResultSet
            );

            $paginator = new Paginator($paginatorAdapter);
            return $paginator;
        }

        $resultSet = $this->videoModel->tableGateway->select();
        return $resultSet;
    }

    public function fetch($id)
    {
        $video = $this->videoModel->fetch($id);
        if (!$video) {
            return null;
        }

        $this->videoHydrator->setParam('embedChannel');

        return $this->videoHydrator->buildEntity($video);
    }

    public function fetchByChannel($channelId)
    {
        return $this->videoModel->fetchByChannel($channelId);
    }

    public function fetchByUser($userId)
    {
        return $this->videoModel->fetchByUser($userId);
    }
}
