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
