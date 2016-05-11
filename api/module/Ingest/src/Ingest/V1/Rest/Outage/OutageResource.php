<?php
namespace Ingest\V1\Rest\Outage;

use ZF\ApiProblem\ApiProblem;
use Application\Rest\AbstractResourceListener;

class OutageResource extends AbstractResourceListener
{
    public function __construct($identityService, $ingestService)
    {
        $this->identityService = $identityService;
        $this->service = $ingestService;
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
            'ingest_id' => $this->getEvent()->getRouteParam('ingest_id')
        );

        return $this->service->fetchOutages(array_merge($data, (array) $params));
    }
}
