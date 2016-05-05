<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace RTMP\V1\Rpc\Translate;

use Application\Authorization\LocalhostController;
use ZF\ContentNegotiation\ViewModel;

class TranslateController extends LocalhostController
{
    private $channelModel;

    public function __construct($channelModel)
    {
        $this->channelModel = $channelModel;
    }

    public function translateAction()
    {
        $this->assertLocalConnection();

        $streamKey = $this->getEvent()->getRequest()->getQuery('stream_key');
        if (is_null($streamKey)) {
            return new ViewModel();
        }

        $channel = $this->channelModel->fetchByStreamKey($streamKey);
        if (is_null($channel)) {
            return new ViewModel();
        }

        return new ViewModel(array(
            'channel' => $channel->channel_id
        ));
    }
}
