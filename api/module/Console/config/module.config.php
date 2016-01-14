<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Console\\Controller\\Irc\\IrcClient' => 'Console\\Controller\\Irc\\IrcClient',
            'Console\\Controller\\Irc\\IrcGateway' => 'Console\\Controller\\Irc\\IrcGateway',
            'Console\\Controller\\WebSocket\\WebSocketEventGateway' => 'Console\\Controller\\WebSocket\\WebSocketEventGateway',
            'Console\\Controller\\WebSocket\\WebSocketServer' => 'Console\\Controller\\WebSocket\\WebSocketServer',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'irc-gateway' => array(
                    'options' => array(
                        'route'    => 'irc gateway',
                        'defaults' => array(
                            'controller' => 'Console\Controller\Irc\IrcGateway',
                            'action'     => 'run'
                        ),
                    ),
                ),
                'irc-register ' => array(
                    'options' => array(
                        'route'    => 'irc register <username> <password>',
                        'defaults' => array(
                            'controller' => 'Console\Controller\Irc\IrcClient',
                            'action'     => 'register'
                        ),
                    ),
                ),
                'irc-send ' => array(
                    'options' => array(
                        'route'    => 'irc send <command>',
                        'defaults' => array(
                            'controller' => 'Console\Controller\Irc\IrcClient',
                            'action'     => 'send'
                        ),
                    ),
                ),
                'websocket-server' => array(
                    'options' => array(
                        'route'    => 'websocket server',
                        'defaults' => array(
                            'controller' => 'Console\Controller\WebSocket\WebSocketServer',
                            'action'     => 'run'
                        ),
                    ),
                ),
            )
        )
    ),
);
