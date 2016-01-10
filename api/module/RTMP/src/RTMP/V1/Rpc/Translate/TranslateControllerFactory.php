<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace RTMP\V1\Rpc\Translate;

class TranslateControllerFactory
{
    public function __invoke($controllers)
    {
        $services = $controllers->getServiceLocator();

        return new TranslateController(
            $services->get('Application\Database\Stream\StreamModel')
        );
    }
}
