<?php
return array(
    'router' => array(
        'routes' => array(
            'oauth' => array(
                'options' => array(
                    'spec' => '%oauth%',
                    'regex' => '(?P<oauth>(/oauth2))',
                ),
                'type' => 'regex',
            ),
        ),
    ),
    'db' => array(
        'adapters' => array(
            'PostgreSQL' => array(),
        ),
    ),
);
