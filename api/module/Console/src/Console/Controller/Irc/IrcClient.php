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
use React\Stream\Stream As ReactStream;
use RuntimeException;

class IrcClient extends AbstractConsoleController
{
    private $gatewayClient;

    public function sendAction($commands = null)
    {
        $request = $this->getRequest();
        if (is_null($commands)) {
            $commands = $request->getParam('command');
        }

        if (!is_array($commands)) {
            $commands = array($commands);
        }

        foreach ($commands as $command) {
            $this->send($command);
            usleep(100000);
        }

        return true;
    }

    public function registerAction()
    {
        $request = $this->getRequest();
        $username = $request->getParam('username');
        $password = $request->getParam('password');

        $registerCommands = array(
            'PRIVMSG NickServ LOGOUT',
            'NICK ' . $this->getConfig('irc')['nick'] . '-tmp',
            'NICK ' . $this->getConfig('irc')['nick'],
            'PRIVMSG NickServ IDENTIFY ' . $this->getConfig('irc')['password'],
            'PRIVMSG ChanServ KICK #' . $username . ' *',
            'PRIVMSG ChanServ DROP #' . $username . ' #' . $username,
            //'KILL '.$username. ' Registering the username',
            'PRIVMSG NickServ DROP ' . $username,

            'PRIVMSG NickServ LOGOUT',
            'NICK ' . $username,
            'PRIVMSG NickServ REGISTER ' . $password . ' ' . $username . '@neap.dev',
            'PRIVMSG NickServ LOGOUT',

            'NICK ' . $this->getConfig('irc')['nick'],
            'PRIVMSG NickServ IDENTIFY ' . $this->getConfig('irc')['password'],
            'JOIN #' . $username,
            'PRIVMSG ChanServ REGISTER #' . $username,
            'PRIVMSG ChanServ SET AUTOOP #' . $username . ' ON',
            'PRIVMSG ChanServ SET KEEPMODES #' . $username . ' ON',
            'PRIVMSG ChanServ SET PERSIST #' . $username . ' ON',
            'PRIVMSG ChanServ SET SECUREFOUNDER #' . $username . ' ON',
            'PRIVMSG ChanServ SET SECUREOPS #' . $username . ' ON',
            'PRIVMSG ChanServ SET FOUNDER #' . $username . ' ' . $username,
            'PRIVMSG ChanServ QOP #' . $username . ' ADD ' . $username,
            //'PRIVMSG ChanServ AOP #'.$username.' ADD toto',
            'PRIVMSG BotServ KICK BADWORDS #' . $username . ' ON',
            'PRIVMSG BotServ KICK FLOOD #' . $username . ' ON',
            'PRIVMSG BotServ KICK REPEAT #' . $username . ' ON',
            'PRIVMSG OperServ UPDATE',
            'PART #' . $username,
        );

        $this->sendAction($registerCommands);
    }

    private function send($command, $timeout = 2)
    {
        $command .= PHP_EOL;

        print ConsoleStyle::build('{green}[' . DateConverter::fromTimestamp() . ']{/} ==>') . PHP_EOL . $command; //displays it on the screen

        $loop = ReactEventLoopFactory::create();

        $gatewaySocket = stream_socket_client('tcp://localhost:' . $this->getConfig('gateway')['port']);
        $this->gatewayClient = new ReactStream($gatewaySocket, $loop);
        $this->gatewayClient->on('data', function($data) {
            $this->receive($data);
            $this->gatewayClient->close();
        });

        $this->gatewayClient->write($command);

        $loop->run();
    }

    private function receive($data)
    {
        print ConsoleStyle::build('{yellow}[' . DateConverter::fromTimestamp() . ']{/} <==') . PHP_EOL . $data;
    }
}
