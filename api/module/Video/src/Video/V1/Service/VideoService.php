<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Video\V1\Service;

use Application\Database\Video\Video;
use Video\V1\Rest\Video\VideoCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class VideoService
{
    private $services;

    public function __construct($services)
    {
        $this->services = $services;
    }

    public function fetchAll($params = [])
    {
        $videoModel = $this->services->get('Application\Database\Video\VideoModel');
        $videoHydrator = $this->services->get('Application\Hydrator\Video\VideoHydrator');

        $select = $videoModel->getSqlSelect();

        $videoHydrator->setParam('linkStream', true);
        $videoHydrator->setParam('linkChannel', true);
        $videoHydrator->setParam('linkUser', true);

        $hydratingResultSet = new HydratingResultSet(
            $videoHydrator,
            new Video()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $videoModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new VideoCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($videoId)
    {
        $videoModel = $this->services->get('Application\Database\Video\VideoModel');
        $videoHydrator = $this->services->get('Application\Hydrator\Video\VideoHydrator');

        $video = $videoModel->fetch($videoId);
        if (!$video) {
            return null;
        }

        $videoHydrator->setParam('linkStream', true);
        $videoHydrator->setParam('linkChannel', true);
        $videoHydrator->setParam('linkUser', true);

        return $videoHydrator->buildEntity($video);
    }

    public function fetchByChannel($channelId)
    {
        $videoModel = $this->services->get('Application\Database\Video\VideoModel');

        return $videoModel->fetchByChannel($channelId);
    }

    public function fetchByUser($userId)
    {
        $videoModel = $this->services->get('Application\Database\Video\VideoModel');

        return $videoModel->fetchByUser($userId);
    }
}
