<?php

namespace Console\Controller;

use Application\Console\AbstractConsoleController;
use Application\Console\ConsoleStyle;
use Zend\View\Model\ViewModel;
use Console\Invokable\Irc\Gateway as IrcGateway;
use Console\Invokable\Irc\Client as IrcClient;

class ServiceController extends AbstractConsoleController
{
    private $pidFile = '/bin/neap.pid';
    private $ircGateway;
    private $ircClient;

    public function serviceAction()
    {
        $this->ircGateway = new IrcGateway($this->getConfig());

        // Fork the current process
        $pid = pcntl_fork();

        // Run the gateway inside the child process
        if ($pid === 0) {
            // Make the current process a session leader
            posix_setsid();

            // Write a pid file to mark as running
            file_put_contents(
                getcwd().$this->pidFile,
                getmypid().PHP_EOL
            );

            // Run the IRC gateway listener
            $this->ircGateway->run();
        }

        // Exit the parent, acting as launcher
        exit(0);
    }
}
