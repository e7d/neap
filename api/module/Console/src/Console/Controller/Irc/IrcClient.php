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

namespace Console\Controller\Irc;

use Application\Console\AbstractConsoleController;
use Application\Console\ConsoleStyle;
use Application\Converter\DateConverter;
use React\EventLoop\Factory as ReactEventLoopFactory;
use React\Stream\Stream as ReactStream;

/**
 * @codeCoverageIgnore
 */
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
            'NICK '.$this->getConfig('irc')['nick'].'-tmp',
            'NICK '.$this->getConfig('irc')['nick'],
            'PRIVMSG NickServ IDENTIFY '.$this->getConfig('irc')['password'],
            'PRIVMSG ChanServ KICK #'.$username.' *',
            'PRIVMSG ChanServ DROP #'.$username.' #'.$username,
            'KILL '.$username. ' Registering the username',
            'PRIVMSG NickServ DROP '.$username,

            'PRIVMSG NickServ LOGOUT',
            'NICK '.$username,
            'PRIVMSG NickServ REGISTER '.$password.' '.$username.'@neap.dev',
            'PRIVMSG NickServ LOGOUT',

            'NICK '.$this->getConfig('irc')['nick'],
            'PRIVMSG NickServ IDENTIFY '.$this->getConfig('irc')['password'],
            'JOIN #'.$username,
            'PRIVMSG ChanServ REGISTER #'.$username,
            'PRIVMSG ChanServ SET AUTOOP #'.$username.' ON',
            'PRIVMSG ChanServ SET KEEPMODES #'.$username.' ON',
            'PRIVMSG ChanServ SET PERSIST #'.$username.' ON',
            'PRIVMSG ChanServ SET SECUREFOUNDER #'.$username.' ON',
            'PRIVMSG ChanServ SET SECUREOPS #'.$username.' ON',
            'PRIVMSG ChanServ SET FOUNDER #'.$username.' '.$username,
            'PRIVMSG ChanServ QOP #'.$username.' ADD '.$username,
            'PRIVMSG BotServ KICK BADWORDS #'.$username.' ON',
            'PRIVMSG BotServ KICK FLOOD #'.$username.' ON',
            'PRIVMSG BotServ KICK REPEAT #'.$username.' ON',
            'PRIVMSG OperServ UPDATE',
            'PART #'.$username,
        );

        $this->sendAction($registerCommands);

        return true;
    }

    /**
     * @codeCoverageIgnore
     */
    private function send($command, $timeout = 2)
    {
        $command .= PHP_EOL;

        $loop = ReactEventLoopFactory::create();

        try {
            $gatewaySocket = stream_socket_client('tcp://127.0.0.1:'.$this->getConfig('gateway')['port'], $errno, $errstr, 5);
            if (!$gatewaySocket) {
                print '['.DateConverter::fromTimestamp().'] '.ConsoleStyle::build('{red}Error:{/} ')."$errstr ($errno)"; //displays it on the screen
                return;
            }
        } catch (\Exception $e) {
            print '['.DateConverter::fromTimestamp().'] '.ConsoleStyle::build('{red}Error:{/} ').$e->getMessage(); //displays it on the screen
            return;
        }



        $this->gatewayClient = new ReactStream($gatewaySocket, $loop);
        $this->gatewayClient->on('data', function($data) {
            $this->receive($data);
            $this->gatewayClient->close();
        });

        print '['.DateConverter::fromTimestamp().']'.ConsoleStyle::build(' {green}==>{/} ').PHP_EOL.$command; //displays it on the screen
        $this->gatewayClient->write($command);

        $loop->run();
    }

    /**
     * @codeCoverageIgnore
     */
    private function receive($data)
    {
        print '['.DateConverter::fromTimestamp().']'.ConsoleStyle::build(' {yellow}<=={/} ').PHP_EOL.$data;
    }
}
