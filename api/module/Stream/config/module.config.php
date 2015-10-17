<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Stream\\V1\\Rest\\Streams\\StreamsResource' => 'Stream\\V1\\Rest\\Streams\\StreamsResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'stream.rest.streams' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/streams[/:stream_id]',
                    'defaults' => array(
                        'controller' => 'Stream\\V1\\Rest\\Streams\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            1 => 'stream.rest.streams',
        ),
    ),
    'zf-rest' => array(
        'Stream\\V1\\Rest\\Streams\\Controller' => array(
            'listener' => 'Stream\\V1\\Rest\\Streams\\StreamsResource',
            'route_name' => 'stream.rest.streams',
            'route_identifier_name' => 'stream_id',
            'collection_name' => 'streams',
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
            'page_size_param' => null,
            'entity_class' => 'Stream\\V1\\Rest\\Streams\\StreamsEntity',
            'collection_class' => 'Stream\\V1\\Rest\\Streams\\StreamsCollection',
            'service_name' => 'Streams',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Stream\\V1\\Rest\\Streams\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Stream\\V1\\Rest\\Streams\\Controller' => array(
                0 => 'application/vnd.stream.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Stream\\V1\\Rest\\Streams\\Controller' => array(
                0 => 'application/vnd.stream.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Stream\\V1\\Rest\\Streams\\StreamsEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'stream.rest.streams',
                'route_identifier_name' => 'stream_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Stream\\V1\\Rest\\Streams\\StreamsCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'stream.rest.streams',
                'route_identifier_name' => 'stream_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Stream\\V1\\Rest\\Streams\\Controller' => array(
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
