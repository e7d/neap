<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Console\Controller\Irc;

use Application\Console\AbstractConsoleController;
use Application\Console\ConsoleStyle;
use Application\Converter\DateConverter;
use React\EventLoop\Factory as ReactEventLoopFactory;
use React\Socket\Server as ReactServer;
use React\Stream\Stream as ReactStream;

/**
 * @codeCoverageIgnore
 */
class IrcGateway extends AbstractConsoleController
{
    private $gatewayConnections = array();
    private $gatewayListener;
    private $ircClient;
    private $pidFile = '/bin/neap-irc.pid';
    private $ready = false;

    public function runAction()
    {
        // Write a pid file to mark as running
        file_put_contents(
            getcwd().$this->pidFile,
            getmypid().PHP_EOL
        );

        $this->config = $this->getConfig();

        $loop = ReactEventLoopFactory::create();

        $this->gatewayListener = new ReactServer($loop);
        $this->gatewayListener->on('connection', function($gatewayConnection) {
            $gatewayConnection->on('data', function($command) use ($gatewayConnection) {
                if ($this->ready) {
                    $this->send($command, $gatewayConnection);
                } else {
                    $gatewayConnection->write('Error: The IRC gateway isn\'t ready yet.');
                }
            });
        });
        $this->gatewayListener->listen($this->config['gateway']['port'], 'localhost');

        $ircSocket = stream_socket_client('tcp://'.$this->config['irc']['hostname'].':'.$this->config['irc']['port']);
        $this->ircClient = new ReactStream($ircSocket, $loop);
        $this->ircClient->on('data', function($data) {
            $this->receive($data);
        });

        // Upon start, authenticate with IRC server
        $this->send(sprintf('USER %s %s@%s %s@%s PHP Bot', $this->config['irc']['nick'], $this->config['irc']['nick'], $this->config['irc']['hostname'], $this->config['irc']['nick'], $this->config['irc']['hostname']));
        $this->send(sprintf('NICK %s', $this->config['irc']['nick']));

        $loop->run();
    }

    private function send($command, $gatewayConnection = null)
    {
        // This command comes from the gateway server, so we store the connection to transmit the future reponse
        if (!is_null($gatewayConnection)) {
            $this->gatewayConnections[] = $gatewayConnection;
        }

        // Transmit formatted command to IRC server
        $command .= PHP_EOL;
        $this->ircClient->write($command);

        // Print what we sent
        print ConsoleStyle::build('{green}['.DateConverter::fromTimestamp().']{/} ==> ').PHP_EOL.$command; //displays it on the screen
    }

    private function receive($data)
    {
        // Print what we received
        print ConsoleStyle::build('{yellow}['.DateConverter::fromTimestamp().']{/} <== ').PHP_EOL.$data;

        // If we receive data with a populated upon stack, we have something to give back
        if (count($this->gatewayConnections) > 0) {
            $gatewayConnection = array_shift($this->gatewayConnections);
            $gatewayConnection->write($data);
        }

        // Ping response to keep alive
        if (substr($data, 0, 4) == "PING") {
            $this->send("PONG ".substr($data, 5));
        }

        // Get operator privileges
        // Also, try to identify with serviceManager
        if (preg_match(sprintf('/:%s MODE %s :\+iwx/', $this->config['irc']['nick'], $this->config['irc']['nick']), $data)) {
            $this->send(sprintf('OPER %s %s', $this->config['irc']['nick'], $this->config['irc']['oper_phrase']));
            $this->send(sprintf('PRIVMSG NickServ IDENTIFY %s', $this->config['irc']['password']));
        }

        // Check when OPER is ready!
        if (preg_match(sprintf('/%s@%s is now an IRC operator/', $this->config['irc']['nick'], $this->config['irc']['hostname']), $data)) {
            $this->ready = true;
        }

        // Register with serviceManager, if not done yet
        if (preg_match("/Nick .* isn't registered/i", $data)) {
            $this->send(sprintf('PRIVMSG NickServ REGISTER %s', $this->config['irc']['password']));
        }
    }
}
