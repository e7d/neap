<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Stream\Service;

use Application\Database\Stream\Stream;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
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

    public function fetchAll($params, $live = true)
    {
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
            $this->streamModel->tableGateway->getAdapter(),
            $hydratingResultSet
        );

        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
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

    public function fetchByChannel($channelId, $live = true)
    {
        return $this->streamModel->fetchByChannel($channelId, $live);
    }

    public function fetchByUser($userId, $live = true)
    {
        return $this->streamModel->fetchByUser($userId, $live);
    }
}
