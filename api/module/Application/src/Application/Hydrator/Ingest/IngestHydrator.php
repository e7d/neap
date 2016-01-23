<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Ingest;

use Application\Hydrator\Hydrator;
use ZF\Hal\Entity;

class IngestHydrator extends Hydrator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function buildEntity($ingest)
    {
        $ingestEntity = new Entity($this->extract($ingest));

        $ingestEntity->getLinks()->add($this->link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'ingest.rest.ingest',
                'params' => array(
                    'ingest_id' => $ingest->ingest_id,
                ),
            ),
        )));

        if ($this->getParam('linkOutages')) {
            $ingestEntity->getLinks()->add($this->link::factory(array(
                'rel' => 'outages',
                'route' => array(
                    'name' => 'ingest.rest.outage',
                    'params' => array(
                        'ingest_id' => $ingest->ingest_id,
                    ),
                ),
            )));
        }

        return $ingestEntity;
    }
}
