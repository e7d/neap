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

namespace RTMP\V1\Rpc\Translate;

use Application\Authorization\LocalhostController;
use Zend\Http\Request;
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

        $request = $this->getEvent()->getRequest();
        if ($request instanceof Request) {
            $streamKey = $request->getQuery('stream_key');
            if (is_null($streamKey)) {
                return new ViewModel();
            }
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
