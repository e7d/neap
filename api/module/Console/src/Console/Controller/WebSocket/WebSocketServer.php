<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Console\Controller\WebSocket;

use Application\Console\AbstractConsoleController;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

/**
 * @codeCoverageIgnore
 */
class WebSocketServer extends AbstractConsoleController
{
    private $pidFile = '/bin/neap-websocket.pid';

    public function runAction()
    {
        // Write a pid file to mark as running
        file_put_contents(
            getcwd().$this->pidFile,
            getmypid().PHP_EOL
        );

        // Run the server application through the WebSocket protocol on port 8080
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new WebSocketEventGateway()
                )
            ),
            8010
        );

        $server->run();
    }
}
