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

namespace Application\Hydrator\Panel;

use Application\Database\Channel\ChannelModel;
use Application\Database\Panel\Panel;
use Application\Hydrator\Hydrator;
use ZF\Hal\Entity;

/**
 * PanelHydrator
 */
class PanelHydrator extends Hydrator
{
    /** @var ChannelModel */
    protected $channelModel;

    /**
     * @param ChannelModel $channelModel
     */
    public function __construct(ChannelModel $channelModel)
    {
        parent::__construct();
        $this->channelModel = $channelModel;
    }

    /**
     * @param Panel $panel
     *
     * @return Entity
     */
    public function buildEntity($panel)
    {
        $this->object = $panel;

        $channel = $this->channelModel->fetch($panel->channel_id);

        $this->addEmbed('embedChannel', $channel);

        $this->entity = new Entity($this->extract($panel), $panel->panel_id);

        $this->addSelfLink();
        $this->addLink('linkChannel', $channel);

        return $this->entity;
    }
}
