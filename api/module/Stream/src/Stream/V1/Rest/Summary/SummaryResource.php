<?php
namespace Stream\V1\Rest\Summary;

use Zend\Stdlib\Hydrator\ObjectProperty;
use ZF\ApiProblem\ApiProblem;
use Application\Rest\AbstractResourceListener;

class SummaryResource extends AbstractResourceListener
{
    public function __construct($identityService, $streamService)
    {
        $this->identityService = $identityService;
        $this->service = $streamService;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $data = array(
            'live' => is_null($this->getEvent()->getQueryParam('all'))
        );

        $stats = $this->service->fetchStats(array_merge($data, (array) $params));

        $entity = new ObjectProperty();
        $entity->hydrate($stats, $entity);

        return $entity;
    }
}
