<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Team\V1\Rest\User;

use ZF\ApiProblem\ApiProblem;
use Application\Rest\AbstractResourceListener;

class UserResource extends AbstractResourceListener
{
    public function __construct($identityService, $teamService)
    {
        $this->identityService = $identityService;
        $this->service = $teamService;
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
            'team_id' => $this->getEvent()->getRouteParam('team_id')
        );

        return $this->service->fetchUsers(array_merge($data, (array) $params));
    }
}
