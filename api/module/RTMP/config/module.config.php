<?php
return array(
    'controllers' => array(
        'factories' => array(
            'RTMP\\V1\\Rpc\\Translate\\Controller' => 'RTMP\\V1\\Rpc\\Translate\\TranslateControllerFactory',
            'RTMP\\V1\\Rpc\\Event\\Controller' => 'RTMP\\V1\\Rpc\\Event\\EventControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'rtmp.rpc.translate' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/rtmp/translate',
                    'defaults' => array(
                        'controller' => 'RTMP\\V1\\Rpc\\Translate\\Controller',
                        'action' => 'translate',
                    ),
                ),
            ),
            'rtmp.rpc.event' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/rtmp/event',
                    'defaults' => array(
                        'controller' => 'RTMP\\V1\\Rpc\\Event\\Controller',
                        'action' => 'event',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'rtmp.rpc.translate',
            1 => 'rtmp.rpc.event',
        ),
    ),
    'zf-rpc' => array(
        'RTMP\\V1\\Rpc\\Translate\\Controller' => array(
            'service_name' => 'Translate',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'rtmp.rpc.translate',
        ),
        'RTMP\\V1\\Rpc\\Event\\Controller' => array(
            'service_name' => 'Event',
            'http_methods' => array(
                0 => 'POST',
            ),
            'route_name' => 'rtmp.rpc.event',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'RTMP\\V1\\Rpc\\Translate\\Controller' => 'Json',
            'RTMP\\V1\\Rpc\\Event\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'RTMP\\V1\\Rpc\\Translate\\Controller' => array(
                0 => 'application/vnd.rtmp.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'RTMP\\V1\\Rpc\\Event\\Controller' => array(
                0 => 'application/vnd.rtmp.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
                3 => 'application/x-www-form-urlencoded',
            ),
        ),
        'content_type_whitelist' => array(
            'RTMP\\V1\\Rpc\\Translate\\Controller' => array(
                0 => 'application/vnd.rtmp.v1+json',
                1 => 'application/json',
            ),
            'RTMP\\V1\\Rpc\\Event\\Controller' => array(
                0 => 'application/vnd.rtmp.v1+json',
                1 => 'application/json',
                2 => 'application/x-www-form-urlencoded',
            ),
        ),
    ),
);
