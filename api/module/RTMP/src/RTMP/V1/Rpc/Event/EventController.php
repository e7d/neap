<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace RTMP\V1\Rpc\Event;

use Application\Authorization\LocalhostController;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use ZF\ContentNegotiation\ViewModel;

class EventController extends LocalhostController
{
    private $channelModel;
    private $ingestModel;
    private $streamModel;

    public function __construct($channelModel, $ingestModel, $streamModel)
    {
        $this->channelModel = $channelModel;
        $this->ingestModel = $ingestModel;
        $this->streamModel = $streamModel;
    }

    public function eventAction()
    {
        try {
            $this->assertLocalConnection();

            switch ($_POST['app']) {
                case 'transcode':
                    $streamKey = $_POST['name'];
                    $hostname = parse_url($_POST['tcurl'], PHP_URL_HOST);

                    switch ($_POST['call']) {
                        case 'publish':
                            $channel = $this->channelModel->fetchByStreamKey($streamKey);

                            if (is_null($channel)) {
                                return new ApiProblemResponse(
                                    new ApiProblem(403, 'This stream key is invalid')
                                );
                            }

                            $ingest = $this->ingestModel->fetchByHostname($hostname);

                            $this->streamModel->create(array(
                                'channel_id' => $channel->channel_id,
                                'ingest_id' => $ingest->ingest_id,
                                'title' => $channel->title,
                                'topic_id' => $channel->topic_id,
                                'topic' => $channel->topic,
                            ));

                            break;
                        case 'publish_done':
                            $channel = $this->channelModel->fetchByStreamKey($streamKey);

                            if (is_null($channel)) {
                                return new ApiProblemResponse(
                                    new ApiProblem(403, 'This stream key is invalid')
                                );
                            }

                            $stream = $this->streamModel->fetchByChannel($channel->channel_id);

                            $now = \DateTime::createFromFormat('U.u', microtime(true));
                            $this->streamModel->update(
                                $stream->stream_id,
                                array(
                                    'ended_at' => $now->format('Y-m-d H:i:s.uO')
                                )
                            );

                            break;
                    }
            }

            return new ViewModel(array());
        } catch (\DomainException $e) {
            return new ApiProblemResponse(
                new ApiProblem(403, 'This route must be invoked from the local host')
            );
        } catch (\Exception $e) {
            return new ApiProblemResponse(
                new ApiProblem(500, 'A technical error occured')
            );
        }
    }
}
