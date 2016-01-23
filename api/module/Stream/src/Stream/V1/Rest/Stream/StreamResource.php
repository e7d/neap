<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Stream\V1\Rest\Stream;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class StreamResource extends AbstractResourceListener
{
    private $identityService;
    private $streamService;

    public function __construct($identityService, $streamService)
    {
        $this->identityService = $identityService;
        $this->streamService = $streamService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $streamId
     * @return ApiProblem|mixed
     */
    public function fetch($streamId)
    {
        return $this->streamService->fetch($streamId);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->streamService->fetchAll($params);
    }
}
