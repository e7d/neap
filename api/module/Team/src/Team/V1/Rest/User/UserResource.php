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
