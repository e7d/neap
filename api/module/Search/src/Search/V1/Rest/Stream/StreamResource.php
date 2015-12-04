<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Search\V1\Rest\Stream;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class StreamResource extends AbstractResourceListener
{
    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params)
    {
        return new ApiProblem(405, 'The GET method has not been defined for collections');
    }
}
