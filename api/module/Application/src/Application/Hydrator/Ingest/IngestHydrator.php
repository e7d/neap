<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Hydrator\Ingest;

use Application\Hydrator\Hydrator;
use Application\Database\Channel\ChannelModel;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class IngestHydrator extends Hydrator
{
    public function __construct()
    {
    }

    public function buildEntity($ingest)
    {
        $ingestEntity = new Entity($this->extract($ingest));

        $ingestEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'ingest.rest.ingest',
                'params' => array(
                    'ingest_id' => $ingest->id,
                ),
            ),
        )));

        if ($this->getParam('linkOutages')) {
            $ingestEntity->getLinks()->add(Link::factory(array(
                'rel' => 'outages',
                'route' => array(
                    'name' => 'ingest.rest.outage',
                    'params' => array(
                        'ingest_id' => $ingest->id,
                    ),
                ),
            )));
        }

        return $ingestEntity;
    }
}
