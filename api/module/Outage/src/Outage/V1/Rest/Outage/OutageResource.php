<?php
namespace Outage\V1\Rest\Outage;

use ZF\ApiProblem\ApiProblem;
use Application\Rest\AbstractResourceListener;

class OutageResource extends AbstractResourceListener
{
    public function __construct($identityService, $outageService)
    {
        $this->identityService = $identityService;
        $this->service = $outageService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $outageId
     * @return ApiProblem|mixed
     */
    public function fetch($outageId)
    {
        return $this->service->fetch($outageId);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->service->fetchAll($params);
    }
}
