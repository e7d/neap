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

class TranslateController extends LocalhostController
{
    private $streamModel;

    public function __construct($streamModel)
    {
        $this->streamModel = $streamModel;
    }

    public function translateAction()
    {
        $this->assertLocalConnection();

        $streamKey = $this->getEvent()->getRequest()->getQuery('stream_key');
        if (is_null($streamKey)) {
            exit;
        }

        $stream = $this->streamModel->fetchByStreamKey($streamKey);
        if (is_null($stream)) {
            exit;
        }

        print $stream->id;
        exit;
    }
}
