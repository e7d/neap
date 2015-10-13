<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Stream\\V1\\Rest\\Stream\\StreamResource' => 'Stream\\V1\\Rest\\Stream\\StreamResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'stream.rest.stream' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/stream[/:stream_id]',
                    'defaults' => array(
                        'controller' => 'Stream\\V1\\Rest\\Stream\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'stream.rest.stream',
        ),
    ),
    'zf-rest' => array(
        'Stream\\V1\\Rest\\Stream\\Controller' => array(
            'listener' => 'Stream\\V1\\Rest\\Stream\\StreamResource',
            'route_name' => 'stream.rest.stream',
            'route_identifier_name' => 'stream_id',
            'collection_name' => 'stream',
            'entity_http_methods' => array(
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
                1 => 'POST',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Stream\\V1\\Rest\\Stream\\StreamEntity',
            'collection_class' => 'Stream\\V1\\Rest\\Stream\\StreamCollection',
            'service_name' => 'Stream',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Stream\\V1\\Rest\\Stream\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Stream\\V1\\Rest\\Stream\\Controller' => array(
                0 => 'application/vnd.stream.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Stream\\V1\\Rest\\Stream\\Controller' => array(
                0 => 'application/vnd.stream.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Stream\\V1\\Rest\\Stream\\StreamEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'stream.rest.stream',
                'route_identifier_name' => 'stream_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Stream\\V1\\Rest\\Stream\\StreamCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'stream.rest.stream',
                'route_identifier_name' => 'stream_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Stream\\V1\\Rest\\Stream\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
        ),
    ),
);
