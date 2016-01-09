<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Outage;

use Application\Hydrator\Hydrator;
use Application\Database\Ingest\IngestModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class OutageHydrator extends Hydrator
{
    protected $ingestModel;

    public function __construct(IngestModel $ingestModel)
    {
        $this->ingestModel = $ingestModel;
    }

    public function buildEntity($outage)
    {
        $ingest = $this->ingestModel->fetch($outage->ingest_id);

        $outageEntity = new Entity($this->extract($outage));

        $outageEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'outage.rest.outage',
                'params' => array(
                    'outage_id' => $outage->id,
                ),
            ),
        )));

        if ($this->getParam('linkIngest')) {
            $outageEntity->getLinks()->add(Link::factory(array(
                'rel' => 'ingest',
                'route' => array(
                    'name' => 'ingest.rest.ingest',
                    'params' => array(
                        'ingest_id' => $ingest->id,
                    ),
                ),
            )));
            unset($outage->ingest_id);
        }

        return $outageEntity;
    }
}
