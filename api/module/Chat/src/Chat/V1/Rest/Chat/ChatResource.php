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

namespace Chat\V1\Rest\Chat;

use ZF\ApiProblem\ApiProblem;
use Application\Rest\AbstractResourceListener;

class ChatResource extends AbstractResourceListener
{
    public function __construct($identityService, $chatService)
    {
        $this->identityService = $identityService;
        $this->service = $chatService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $chatId
     * @return ApiProblem|mixed
     */
    public function fetch($chatId)
    {
        return $this->service->fetch($chatId);
    }
}
