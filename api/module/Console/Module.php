<?php
namespace Console;

use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module implements
    ConsoleBannerProviderInterface,
    ConsoleUsageProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConsoleBanner(Console $console)
    {
        return "Neap 0.0.1";
    }

    public function getConsoleUsage(Console $console)
    {
        return array(
            'Service',
            'service' => 'Run the gateway service',
            'IRC',
            'irc send <command>'       => 'Send an IRC command',
            'irc register <username>'  => 'Register a user and its channel against IRC',
            array('<command>', 'IRC command', 'Command to execute through the gateway'),
            array('<username>', 'user name', 'The user to register against IRC'),
        );
    }
}
