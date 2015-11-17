<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Hydrator\Outage;

use Application\Hydrator\Hydrator;
use Application\Database\Channel\ChannelModel;
use Application\Database\User\UserModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class OutageHydrator extends Hydrator
{
    public function __construct()
    {
    }

    public function buildEntity($outage)
    {
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

        return $outageEntity;
    }
}
