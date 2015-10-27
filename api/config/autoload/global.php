<?php
return array(
    'router' => array(
        'routes' => array(
            'oauth' => array(
                'options' => array(
                    'spec' => '%oauth%',
                    'regex' => '(?P<oauth>(/oauth))',
                ),
                'type' => 'regex',
            ),
        ),
    ),
    'db' => array(
        'adapters' => array(
            'neap' => array(),
        ),
    ),
    'zf-mvc-auth' => array(
        'authentication' => array(
            'map' => array(
                'User\\V1' => 'oauth2',
                'Channel\\V1' => 'oauth2',
                'Stream\\V1' => 'oauth2',
                'Video\\V1' => 'oauth2',
                'Topic\\V1' => 'oauth2',
                'Panel\\V1' => 'oauth2',
                'Chat\\V1' => 'oauth2',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\\Db\\Adapter\\Adapter' => 'Zend\\Db\\Adapter\\AdapterServiceFactory',
        ),
    ),
);
