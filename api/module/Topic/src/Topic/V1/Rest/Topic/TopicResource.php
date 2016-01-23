<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Topic\V1\Rest\Topic;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class TopicResource extends AbstractResourceListener
{
    private $identityService;
    private $topicService;

    public function __construct($identityService, $topicService)
    {
        $this->identityService = $identityService;
        $this->topicService = $topicService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $topicId
     * @return ApiProblem|mixed
     */
    public function fetch($topicId)
    {
        return $this->topicService->fetch($topicId);
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
            'top' => true
        );

        return $this->topicService->fetchAll(array_merge($data, (array) $params));
    }
}
