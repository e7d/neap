<?php
namespace Stream\V1\Rest\Summary;

use ZF\ApiProblem\ApiProblem;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;
use Application\Rest\AbstractResourceListener;

class SummaryResource extends AbstractResourceListener
{
    public function __construct($identityService, $streamService)
    {
        $this->identityService = $identityService;
        $this->service = $streamService;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        $data = array(
            'live' => is_null($this->getEvent()->getQueryParam('all'))
        );

        $stats = $this->service->fetchStats(array_merge($data, (array) $params));

        $summary = new Entity($stats);
        $summaryLink = new Link('summary');

        $summary->getLinks()->add($summaryLink->factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'stream.rest.summary',
                'params' => array(
                    'all' => 'true'
                )
            ),
        )));

        return $summary;
    }
}
