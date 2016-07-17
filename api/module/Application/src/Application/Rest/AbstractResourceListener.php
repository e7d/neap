<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Rest;

use Application\Authorization\AuthorizationAwareResourceTrait;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener as ZfAbstractResourceListener;
use ZF\Rest\ResourceEvent;

/**
 * AbstractResourceListener handles resource related service
 */

 /**
  * HttpBasicFactory creates services for HTTP basic authentication.
  *
  * @author Fabien Potencier <fabien@symfony.com>
  */
class AbstractResourceListener extends ZfAbstractResourceListener
{
    use AuthorizationAwareResourceTrait;

    /**
     * Internal resource related service
     *
     * @var object
     */
    protected $service;

    /**
     * Returns the resource related service
     *
     * @return object
     */
    protected function getService()
    {
        return $this->service;
    }

    /**
     * Dispatches an incoming event to the appropriate method
     *
     * Marshals arguments from the event parameters.
     *
     * @param ResourceEvent $event
     * @return mixed
     */
    public function dispatch(ResourceEvent $event)
    {
        try {
            return parent::dispatch($event);
        } catch (\Exception $e) {
            return new ApiProblem($e->getCode(), $e);
        }
    }
}
