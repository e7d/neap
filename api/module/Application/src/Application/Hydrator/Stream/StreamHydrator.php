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

namespace Application\Hydrator\Stream;

use Application\Database\Channel\ChannelModel;
use Application\Database\Stream\Stream;
use Application\Database\User\UserModel;
use Application\Hydrator\Hydrator;
use ZF\Hal\Entity;

/**
 * StreamHydrator
 */
class StreamHydrator extends Hydrator
{
    /** @var ChannelModel */
    protected $channelModel;

    /** @var UserModel */
    protected $userModel;

    /**
     * @param ChannelModel $channelModel
     * @param UserModel    $userModel
     */
    public function __construct(ChannelModel $channelModel, UserModel $userModel)
    {
        parent::__construct();
        $this->channelModel = $channelModel;
        $this->userModel = $userModel;
    }

    /**
     * @param Stream $stream
     *
     * @return Entity
     */
    public function buildEntity($stream)
    {
        $this->object = $stream;

        $channel = $this->channelModel->fetch($stream->channel_id);
        $user = $this->userModel->fetch($channel->user_id);

        if (!$this->getParam('keepStreamKey')) {
            unset($channel->stream_key);
        }

        $this->addEmbed('embedChannel', $channel);

        $this->entity = new Entity($this->extract($stream), $stream->stream_id);

        $this->entity->getLinks()->add($this->link->factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'stream.rest.stream',
                'params' => array(
                    'stream_id' => $stream->stream_id,
                ),
            ),
        )));

        $this->addLink('linkChannel', $channel);
        $this->addLink('linkUser', $user);

        return $this->entity;
    }
}
