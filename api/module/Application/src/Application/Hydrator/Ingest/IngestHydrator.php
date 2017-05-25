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

namespace Application\Hydrator\Ingest;

use Application\Database\Ingest\Ingest;
use Application\Hydrator\Hydrator;
use ZF\Hal\Entity;

/**
 * IngestHydrator
 */
class IngestHydrator extends Hydrator
{
    /**
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Ingest $ingest
     *
     * @return Entity
     */
    public function buildEntity($ingest)
    {
        $this->object = $ingest;

        $this->entity = new Entity($this->extract($ingest));

        $this->addSelfLink();
        $this->addLink('linkOutages', $ingest, 'outages', 'ingest.rest.outage');

        return $this->entity;
    }
}
