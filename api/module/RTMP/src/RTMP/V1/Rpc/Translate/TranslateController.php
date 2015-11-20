<?php
namespace RTMP\V1\Rpc\Translate;

use Application\Authorization\LocalhostController;

class TranslateController extends LocalhostController
{
    private $channelService;

    public function __construct($channelService)
    {
        $this->channelService = $channelService;
    }

    public function translateAction()
    {
        $this->assertLocalConnection();

        $streamKey = $this->getEvent()->getRequest()->getQuery('stream_key');
        if (is_null($streamKey)) {
            exit;
        }

        $channel = $this->channelService->fetchByStreamKey($streamKey);
        if (is_null($channel)) {
            exit;
        }

        print $channel->id;
        exit;
    }
}
