<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Video\Service;

use Application\Database\Video\Video;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
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

    public function fetchAll($params)
    {
        $select = new Select('video');

        $this->videoHydrator->setParam('linkStream');
        $this->videoHydrator->setParam('linkChannel');
        $this->videoHydrator->setParam('linkUser');

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

    public function fetch($id)
    {
        $video = $this->videoModel->fetch($id);
        if (!$video) {
            return null;
        }

        $this->videoHydrator->setParam('linkStream');
        $this->videoHydrator->setParam('linkChannel');
        $this->videoHydrator->setParam('linkUser');

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
