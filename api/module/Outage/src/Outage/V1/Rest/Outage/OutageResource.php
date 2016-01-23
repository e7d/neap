<?php
namespace Outage\V1\Rest\Outage;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class OutageResource extends AbstractResourceListener
{
    private $identityService;
    private $outageService;

    public function __construct($identityService, $outageService)
    {
        $this->identityService = $identityService;
        $this->outageService = $outageService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $outageId
     * @return ApiProblem|mixed
     */
    public function fetch($outageId)
    {
        return $this->outageService->fetch($outageId);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->outageService->fetchAll($params);
    }
}
