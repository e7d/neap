<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Chat\V1\Rest\Chat;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class ChatResource extends AbstractResourceListener
{
    private $identityService;
    private $chatService;

    function __construct($identityService, $chatService)
    {
        $this->identityService = $identityService;
        $this->chatService = $chatService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->chatService->fetch($id);
    }
}
