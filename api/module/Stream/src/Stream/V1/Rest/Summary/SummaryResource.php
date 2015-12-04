<?php
namespace Stream\V1\Rest\Summary;

use Zend\Stdlib\Hydrator\ObjectProperty;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class SummaryResource extends AbstractResourceListener
{
    private $identityService;
    private $streamService;

    function __construct($identityService, $streamService)
    {
        $this->identityService = $identityService;
        $this->streamService = $streamService;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params)
    {
        $stats = $this->streamService->fetchStats($params);

        $entity = new ObjectProperty();
        $entity->hydrate($stats, $entity);

        return $entity;
    }
}
