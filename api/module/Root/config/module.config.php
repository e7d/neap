<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Root\\V1\\Rest\\Root\\RootResource' => 'Root\\V1\\Rest\\Root\\RootResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'root.rest.root' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Root\\V1\\Rest\\Root\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'root.rest.root',
        ),
    ),
    'zf-rest' => array(
        'Root\\V1\\Rest\\Root\\Controller' => array(
            'listener' => 'Root\\V1\\Rest\\Root\\RootResource',
            'route_name' => 'root.rest.root',
            'route_identifier_name' => 'root_id',
            'collection_name' => 'root',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Root\\V1\\Rest\\Root\\RootEntity',
            'collection_class' => 'Root\\V1\\Rest\\Root\\RootCollection',
            'service_name' => 'Root',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Root\\V1\\Rest\\Root\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Root\\V1\\Rest\\Root\\Controller' => array(
                0 => 'application/vnd.root.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Root\\V1\\Rest\\Root\\Controller' => array(
                0 => 'application/vnd.root.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Root\\V1\\Rest\\Root\\RootEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'root.rest.root',
                'route_identifier_name' => 'root_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Root\\V1\\Rest\\Root\\RootCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'root.rest.root',
                'route_identifier_name' => 'root_id',
                'is_collection' => true,
            ),
        ),
    ),
);
