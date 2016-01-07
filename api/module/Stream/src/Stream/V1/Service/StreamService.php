<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Stream\V1\Service;

use Application\Database\Stream\Stream;
use Stream\V1\Rest\Stream\StreamCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class StreamService
{
    protected $streamModel;
    protected $streamHydrator;

    public function __construct($streamModel, $streamHydrator)
    {
        $this->streamModel = $streamModel;
        $this->streamHydrator = $streamHydrator;
    }

    public function fetchAll($params = [])
    {
        $live = !array_key_exists('all', $params);

        $select = new Select('stream');

        if ($live) {
            $where = new Where();
            $where->isNull('stream.ended_at');

            $select->where($where);
        }

        $this->streamHydrator->setParam('linkChannel');
        $this->streamHydrator->setParam('linkUser');

        $hydratingResultSet = new HydratingResultSet(
            $this->streamHydrator,
            new Stream()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->streamModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new StreamCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $stream = $this->streamModel->fetch($id);
        if (!$stream) {
            return null;
        }

        $this->streamHydrator->setParam('embedChannel');
        $this->streamHydrator->setParam('linkUser');

        return $this->streamHydrator->buildEntity($stream);
    }

    public function fetchByChannel($channelId)
    {
        $live = !array_key_exists('all', $params);

        $stream = $this->streamModel->fetchByChannel($channelId, $live);
        if (!$stream) {
            return null;
        }

        $this->streamHydrator->setParam('embedChannel');
        $this->streamHydrator->setParam('linkUser');

        return $this->streamHydrator->buildEntity($stream);
    }

    public function fetchByUser($userId, $live = true)
    {
        $live = !array_key_exists('all', $params);

        $stream = $this->streamModel->fetchByUser($userId, $live);
        if (!$stream) {
            return null;
        }

        $this->streamHydrator->setParam('embedChannel');
        $this->streamHydrator->setParam('linkUser');

        return $this->streamHydrator->buildEntity($stream);
    }

    public function fetchStats($params)
    {
        $live = !array_key_exists('all', $params);

        return $this->streamModel->fetchStats($live);
    }
}
