<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Console\\Controller\\ServiceController' => 'Console\\Controller\\ServiceController',
            'Console\\Invokable\\Irc\\Client' => 'Console\\Invokable\\Irc\\Client',
            'Console\\Invokable\\Irc\\Gateway' => 'Console\\Invokable\\Irc\\Gateway',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'service' => array(
                    'options' => array(
                        'route'    => 'service',
                        'defaults' => array(
                            'controller' => 'Console\Controller\ServiceController',
                            'action'     => 'service'
                        ),
                    ),
                ),
                'irc-send ' => array(
                    'options' => array(
                        'route'    => 'irc send <command>',
                        'defaults' => array(
                            'controller' => 'Console\Controller\ServiceController',
                            'action'     => 'ircSend'
                        ),
                    ),
                ),
                'irc-register ' => array(
                    'options' => array(
                        'route'    => 'irc register <username>',
                        'defaults' => array(
                            'controller' => 'Console\Controller\ServiceController',
                            'action'     => 'ircRegister'
                        ),
                    ),
                ),
            )
        )
    ),
);
