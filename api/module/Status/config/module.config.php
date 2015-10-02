<?php
return array(
    'controllers' => array(
        'factories' => array(
            'Status\\V1\\Rpc\\Version\\Controller' => 'Status\\V1\\Rpc\\Version\\VersionControllerFactory',
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
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'status.rpc.version',
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
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Status\\V1\\Rpc\\Version\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'Status\\V1\\Rpc\\Version\\Controller' => array(
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
        ),
    ),
);
