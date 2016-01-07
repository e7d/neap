<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Video\V1\Rest\Video;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class VideoResource extends AbstractResourceListener
{
    private $identityService;
    private $videoService;

    function __construct($identityService, $videoService)
    {
        $this->identityService = $identityService;
        $this->videoService = $videoService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->videoService->fetch($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->videoService->fetchAll($params);
    }
}
