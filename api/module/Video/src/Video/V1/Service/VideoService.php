<?php
/**
 * Neap (http://neap.io/)
 *
 * @package   Neap
 * @author    Michaël "e7d" Ferrand <michael@e7d.io>
 * @copyright 2017 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 * @link      https://github.com/e7d/neap
 *
 * PHP version 7.1
 */

namespace Video\V1\Service;

use Application\Database\Video\Video;
use Video\V1\Rest\Video\VideoCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbSelect;

class VideoService
{
    private $serviceManager;

    public function __construct($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function fetchAll($params = [])
    {
        $videoModel = $this->serviceManager->get('Application\Database\Video\VideoModel');
        $videoHydrator = $this->serviceManager->get('Application\Hydrator\Video\VideoHydrator');

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
        $videoModel = $this->serviceManager->get('Application\Database\Video\VideoModel');
        $videoHydrator = $this->serviceManager->get('Application\Hydrator\Video\VideoHydrator');

        $video = $videoModel->fetch($videoId);
        if (!$video) {
            return null;
        }

        $videoHydrator->setParam('linkStream', true);
        $videoHydrator->setParam('linkChannel', true);
        $videoHydrator->setParam('linkUser', true);

        return $videoHydrator->buildEntity($video);
    }
}
