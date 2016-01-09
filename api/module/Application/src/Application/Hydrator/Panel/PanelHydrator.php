<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Panel;

use Application\Hydrator\Hydrator;
use Application\Database\Channel\ChannelModel;
use Zend\Stdlib\Hydrator\HydratorInterface;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;

class PanelHydrator extends Hydrator
{
    protected $channelModel;

    public function __construct(ChannelModel $channelModel)
    {
        $this->channelModel = $channelModel;
    }

    public function buildEntity($panel)
    {
        $channel = $this->channelModel->fetch($panel->channel_id);

        if ($this->getParam('embedChannel')) {
            $channelEntity = new Entity($channel, $channel->id);
            $channelEntity->getLinks()->add(Link::factory(array(
                'rel' => 'self',
                'route' => array(
                    'name' => 'channel.rest.channel',
                    'params' => array(
                        'channel_id' => $channel->id,
                    ),
                ),
            )));
            $panel->channel = $channelEntity;
            unset($panel->channel_id);
        }

        $panelEntity = new Entity($this->extract($panel), $panel->id);

        $panelEntity->getLinks()->add(Link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'panel.rest.panel',
                'params' => array(
                    'panel_id' => $panel->id,
                ),
            ),
        )));

        if ($this->getParam('linkChannel')) {
            $panelEntity->getLinks()->add(Link::factory(array(
                'rel' => 'channel',
                'route' => array(
                    'name' => 'channel.rest.channel',
                    'params' => array(
                        'channel_id' => $channel->id,
                    ),
                ),
            )));
            unset($panel->channel_id);
        }

        return $panelEntity;
    }
}
