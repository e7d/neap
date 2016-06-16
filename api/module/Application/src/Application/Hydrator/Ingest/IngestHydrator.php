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
        $this->object = $ingest;

        $this->entity = new Entity($this->extract($ingest));

        $this->addSelfLink();
        $this->addLink('linkOutages', $ingest, 'outages', 'ingest.rest.outage');

        return $this->entity;
    }
}
