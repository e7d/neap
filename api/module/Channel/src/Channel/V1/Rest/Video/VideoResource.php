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

namespace Channel\V1\Rest\Video;

use ZF\ApiProblem\ApiProblem;
use Application\Rest\AbstractResourceListener;

class VideoResource extends AbstractResourceListener
{
    public function __construct($identityService, $channelService)
    {
        $this->identityService = $identityService;
        $this->service = $channelService;
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
            'channel_id' => $this->getEvent()->getRouteParam('channel_id')
        );

        return $this->service->fetchVideos(array_merge($data, (array) $params));
    }
}
