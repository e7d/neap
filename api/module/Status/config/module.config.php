<?php
return array(
    'controllers' => array(
        'factories' => array(
            'Status\\V1\\Rpc\\Version\\Controller' => 'Status\\V1\\Rpc\\Version\\VersionControllerFactory',
            'Status\\V1\\Rpc\\Ping\\Controller' => 'Status\\V1\\Rpc\\Ping\\PingControllerFactory',
            'Status\\V1\\Rpc\\Stats\\Controller' => 'Status\\V1\\Rpc\\Stats\\StatsControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'status.rpc.version' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/version',
                    'defaults' => array(
                        'controller' => 'Status\\V1\\Rpc\\Version\\Controller',
                        'action' => 'version',
                    ),
                ),
            ),
            'status.rpc.ping' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/ping',
                    'defaults' => array(
                        'controller' => 'Status\\V1\\Rpc\\Ping\\Controller',
                        'action' => 'ping',
                    ),
                ),
            ),
            'status.rpc.stats' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/stats',
                    'defaults' => array(
                        'controller' => 'Status\\V1\\Rpc\\Stats\\Controller',
                        'action' => 'stats',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'status.rpc.version',
            1 => 'status.rpc.ping',
            2 => 'status.rpc.stats',
        ),
    ),
    'zf-rpc' => array(
        'Status\\V1\\Rpc\\Version\\Controller' => array(
            'service_name' => 'Version',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'status.rpc.version',
        ),
        'Status\\V1\\Rpc\\Ping\\Controller' => array(
            'service_name' => 'Ping',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'status.rpc.ping',
        ),
        'Status\\V1\\Rpc\\Stats\\Controller' => array(
            'service_name' => 'Stats',
            'http_methods' => array(
                0 => 'GET',
            ),
            'route_name' => 'status.rpc.stats',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Status\\V1\\Rpc\\Version\\Controller' => 'Json',
            'Status\\V1\\Rpc\\Ping\\Controller' => 'Json',
            'Status\\V1\\Rpc\\Stats\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'Status\\V1\\Rpc\\Version\\Controller' => array(
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Status\\V1\\Rpc\\Ping\\Controller' => array(
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'Status\\V1\\Rpc\\Stats\\Controller' => array(
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'Status\\V1\\Rpc\\Version\\Controller' => array(
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
            ),
            'Status\\V1\\Rpc\\Ping\\Controller' => array(
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
            ),
            'Status\\V1\\Rpc\\Stats\\Controller' => array(
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Status\\V1\\Rpc\\Ping\\Controller' => array(
            'input_filter' => 'Status\\V1\\Rpc\\Ping\\Validator',
        ),
        'Status\\V1\\Rpc\\Version\\Controller' => array(
            'input_filter' => 'Status\\V1\\Rpc\\Version\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Status\\V1\\Rpc\\Ping\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'ack',
                'description' => 'Acknowledge the request with a timestamp',
            ),
        ),
        'Status\\V1\\Rpc\\Version\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'version',
                'description' => 'Get the API version.',
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Status\\V1\\Rpc\\Stats\\Controller' => array(
                'actions' => array(
                    'Stats' => array(
                        'GET' => false,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => false,
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(),
    ),
    'zf-rest' => array(),
    'zf-hal' => array(
        'metadata_map' => array(),
    ),
);
