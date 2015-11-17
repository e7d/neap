<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Topic\V1\Rest\Topic;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class TopicResource extends AbstractResourceListener
{
    private $identityService;
    private $topicService;

    function __construct($identityService, $topicService)
    {
        $this->identityService = $identityService;
        $this->topicService = $topicService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->topicService->fetch($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params)
    {
        $data = array(
            'top' => true
        );

        return $this->topicService->fetchAll(array_merge($data, (array) $params));
    }
}
