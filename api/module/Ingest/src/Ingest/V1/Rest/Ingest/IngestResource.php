<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Ingest\V1\Rest\Ingest;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class IngestResource extends AbstractResourceListener
{
    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $ingest = new IngestEntity();
        $ingest->id = 'rtmp';
        $ingest->url_template = "rtmp://rtmp.neap.dev/live/{stream_key}";
        return array(
            $ingest
        );
    }
}
