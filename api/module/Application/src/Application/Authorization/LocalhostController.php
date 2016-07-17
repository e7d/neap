<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Authorization;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * Checks the local execution of the application
 */
class LocalhostController extends AbstractActionController
{
    /**
     * Asserts that the current request comes from a local connection
     *
     * @throws \DomainException if the request was not made over a local connection.
     *
     * @return void
     */
    public function assertLocalConnection()
    {
        if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
            throw new \DomainException('Access');
        }
    }
}
