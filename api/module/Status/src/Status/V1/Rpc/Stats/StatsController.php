<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Status\V1\Rpc\Stats;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class StatsController extends AbstractActionController
{
    public function statsAction()
    {
        try {
            $statsXmlStr = file_get_contents("http://neap/stats");
            if (!$statsXmlStr) {
                return new ViewModel();
            }

            $statsXml = simplexml_load_string($statsXmlStr);
            $statsJson = json_encode($statsXml);
            $stats = json_decode($statsJson, true);

            return new ViewModel($stats);
        } catch (\Exception $e) {
            return new ViewModel();
        }
    }
}
