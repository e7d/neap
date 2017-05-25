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

namespace Topic\V1\Rest\Topic;

use ZF\ApiProblem\ApiProblem;
use Application\Rest\AbstractResourceListener;

class TopicResource extends AbstractResourceListener
{
    public function __construct($identityService, $topicService)
    {
        $this->identityService = $identityService;
        $this->service = $topicService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $topicId
     * @return ApiProblem|mixed
     */
    public function fetch($topicId)
    {
        return $this->service->fetch($topicId);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->service->fetchAll((array) $params);
    }
}
