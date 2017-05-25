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

namespace Topic\V1\Service;

use Application\Database\Topic\Topic;
use Topic\V1\Rest\Topic\TopicCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class TopicService
{
    private $serviceManager;

    public function __construct($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function fetchAll($params = [])
    {
        $topicModel = $this->serviceManager->get('Application\Database\Topic\TopicModel');
        $topicHydrator = $this->serviceManager->get('Application\Hydrator\Topic\TopicHydrator');

        $select = $topicModel->selectWithStats();
        if (array_key_exists('top', $params)) {
            $select->order('viewers DESC');
        }

        $hydratingResultSet = new HydratingResultSet(
            $topicHydrator,
            new Topic()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $topicModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new TopicCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($topicId)
    {
        $topicModel = $this->serviceManager->get('Application\Database\Topic\TopicModel');
        $topicHydrator = $this->serviceManager->get('Application\Hydrator\Topic\TopicHydrator');

        $topic = $topicModel->fetch($topicId);
        if (!$topic) {
            return null;
        }

        return $topicHydrator->buildEntity($topic);
    }
}
