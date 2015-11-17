<?php
namespace Ingest\V1\Rest\Outage;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class OutageResource extends AbstractResourceListener
{
    private $identityService;
    private $ingestService;

    function __construct($identityService, $ingestService)
    {
        $this->identityService = $identityService;
        $this->ingestService = $ingestService;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params)
    {
        $params->set('ingest_id', $this->getEvent()->getRouteParam('ingest_id'));

        return $this->ingestService->fetchOutages($params);
    }
}
