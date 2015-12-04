<?php
namespace RTMP\V1\Rpc\Event;

use Application\Authorization\LocalhostController;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;

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

            // $this->log('Event:');
            // $this->log($_POST);

            switch ($_POST['app']) {
                case 'transcode':
                    $streamKey = $_POST['name'];
                    $hostname = parse_url($_POST['tcurl'], PHP_URL_HOST);

                    switch ($_POST['call']) {
                        case 'publish':
                            $channel = $this->channelModel->fetchByStreamKey($streamKey);
                            $ingest = $this->ingestModel->fetchByHostname($hostname);

                            $this->streamModel->create(array(
                                'channel_id' => $channel->id,
                                'ingest_id' => $ingest->id,
                                'title' => $channel->title,
                                'topic_id' => $channel->topic_id,
                                'topic' => $channel->topic,
                            ));

                            break;
                        case 'publish_done':
                            $channel = $this->channelModel->fetchByStreamKey($streamKey);
                            $stream = $this->streamModel->fetchByChannel($channel->id);

                            $now = \DateTime::createFromFormat('U.u', microtime(true));
                            $this->streamModel->update(
                                $stream->id,
                                array(
                                    'ended_at' => $now->format('Y-m-d H:i:s.uO')
                                )
                            );

                            break;
                    }
            }

            exit;
        } catch (\DomainException $e) {
            return new ApiProblemResponse(
                new ApiProblem(403, 'This route must be invoked from the local host')
            );
        }
    }
}
