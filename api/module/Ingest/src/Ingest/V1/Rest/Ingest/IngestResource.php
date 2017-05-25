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

namespace Ingest\V1\Rest\Ingest;

use ZF\ApiProblem\ApiProblem;
use Application\Rest\AbstractResourceListener;

class IngestResource extends AbstractResourceListener
{
    public function __construct($identityService, $ingestService)
    {
        $this->identityService = $identityService;
        $this->service = $ingestService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $ingestId
     * @return ApiProblem|mixed
     */
    public function fetch($ingestId)
    {
        return $this->service->fetch($ingestId);
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
