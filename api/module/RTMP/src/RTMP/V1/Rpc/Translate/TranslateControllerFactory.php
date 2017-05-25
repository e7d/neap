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

namespace RTMP\V1\Rpc\Translate;

class TranslateControllerFactory
{
    public function __invoke($controllers)
    {
        $serviceManager = $controllers->getServiceLocator();

        return new TranslateController(
            $serviceManager->get('Application\Database\Channel\ChannelModel')
        );
    }
}
