<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace User\V1\Rest\Favorite;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class FavoriteResource extends AbstractResourceListener
{
    private $identityService;
    private $userService;

    public function __construct($identityService, $userService)
    {
        $this->identityService = $identityService;
        $this->userService = $userService;
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
            'user_id' => $this->getEvent()->getRouteParam('user_id')
        );

        return $this->userService->fetchFavorites(array_merge($data, (array) $params));
    }
}
