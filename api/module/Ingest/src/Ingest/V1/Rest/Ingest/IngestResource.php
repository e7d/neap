<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Ingest\V1\Rest\Ingest;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class IngestResource extends AbstractResourceListener
{
    private $identityService;
    private $ingestService;

    function __construct($identityService, $ingestService)
    {
        $this->identityService = $identityService;
        $this->ingestService = $ingestService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->ingestService->fetch($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->ingestService->fetchAll($params);
    }
}
