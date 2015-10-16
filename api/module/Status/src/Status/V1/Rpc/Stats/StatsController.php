<?php
namespace Status\V1\Rpc\Stats;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class StatsController extends AbstractActionController
{
    public function statsAction()
    {
        $statsXmlStr = file_get_contents("http://localhost/stats");
        $statsXml = simplexml_load_string($statsXmlStr);
        $statsJson = json_encode($statsXml);
        $stats = json_decode($statsJson, true);

        return new ViewModel(
            $stats
        );
    }
}
