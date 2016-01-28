<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Channel\V1\Rest\Panel;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class PanelResource extends AbstractResourceListener
{
    private $identityService;
    private $channelService;

    public function __construct($identityService, $channelService)
    {
        $this->identityService = $identityService;
        $this->channelService = $channelService;
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

        return $this->channelService->fetchPanels(array_merge($data, (array) $params));
    }
}
