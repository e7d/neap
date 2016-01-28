<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Stream\V1\Service;

use Application\Database\Stream\Stream;
use Stream\V1\Rest\Stream\StreamCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class StreamService
{
    private $services;

    public function __construct($services)
    {
        $this->services = $services;
    }

    public function fetchAll($params = [])
    {
        $streamModel = $this->services->get('Application\Database\Stream\StreamModel');
        $streamHydrator = $this->services->get('Application\Hydrator\Stream\StreamHydrator');

        $live = !array_key_exists('all', $params);

        $select = $streamModel->select($live);

        $streamHydrator->setParam('linkChannel', true);
        $streamHydrator->setParam('linkUser', true);

        $hydratingResultSet = new HydratingResultSet(
            $streamHydrator,
            new Stream()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $streamModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new StreamCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($streamId)
    {
        $streamModel = $this->services->get('Application\Database\Stream\StreamModel');
        $streamHydrator = $this->services->get('Application\Hydrator\Stream\StreamHydrator');

        $stream = $streamModel->fetch($streamId);
        if (!$stream) {
            return null;
        }

        $streamHydrator->setParam('embedChannel', true);
        $streamHydrator->setParam('linkUser', true);

        return $streamHydrator->buildEntity($stream);
    }

    public function fetchByChannel($channelId, $live = null)
    {
        $streamModel = $this->services->get('Application\Database\Stream\StreamModel');
        $streamHydrator = $this->services->get('Application\Hydrator\Stream\StreamHydrator');

        $stream = $streamModel->fetchByChannel($channelId, $live);
        if (!$stream) {
            return null;
        }

        $streamHydrator->setParam('embedChannel', true);
        $streamHydrator->setParam('linkUser', true);

        return $streamHydrator->buildEntity($stream);
    }

    public function fetchByUser($userId, $live = null)
    {
        $streamModel = $this->services->get('Application\Database\Stream\StreamModel');
        $streamHydrator = $this->services->get('Application\Hydrator\Stream\StreamHydrator');

        $stream = $streamModel->fetchByUser($userId, $live);
        if (!$stream) {
            return null;
        }

        $streamHydrator->setParam('embedChannel', true);
        $streamHydrator->setParam('linkUser', true);

        return $streamHydrator->buildEntity($stream);
    }

    public function fetchStats($params)
    {
        $streamModel = $this->services->get('Application\Database\Stream\StreamModel');

        $live = !array_key_exists('all', $params);

        return $streamModel->fetchStats($live);
    }
}
