<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Stream\\V1\\Service\\StreamService' => 'Stream\\V1\\Service\\StreamServiceFactory',
            'Stream\\V1\\Rest\\Stream\\StreamResource' => 'Stream\\V1\\Rest\\Stream\\StreamResourceFactory',
            'Stream\\V1\\Rest\\Summary\\SummaryResource' => 'Stream\\V1\\Rest\\Summary\\SummaryResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'stream.rest.stream' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/streams[/:stream_id]',
                    'defaults' => array(
                        'controller' => 'Stream\\V1\\Rest\\Stream\\Controller',
                    ),
                ),
            ),
            'stream.rest.summary' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/streams/summary',
                    'defaults' => array(
                        'controller' => 'Stream\\V1\\Rest\\Summary\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            1 => 'stream.rest.stream',
            0 => 'stream.rest.summary',
        ),
    ),
    'zf-rest' => array(
        'Stream\\V1\\Rest\\Stream\\Controller' => array(
            'listener' => 'Stream\\V1\\Rest\\Stream\\StreamResource',
            'route_name' => 'stream.rest.stream',
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
            'collection_query_whitelist' => array(
                0 => 'limit',
                1 => 'all',
            ),
            'page_size' => '25',
            'page_size_param' => 'limit',
            'entity_class' => 'Stream\\V1\\Rest\\Stream\\StreamEntity',
            'collection_class' => 'Stream\\V1\\Rest\\Stream\\StreamCollection',
            'service_name' => 'Stream',
        ),
        'Stream\\V1\\Rest\\Summary\\Controller' => array(
            'listener' => 'Stream\\V1\\Rest\\Summary\\SummaryResource',
            'route_name' => 'stream.rest.summary',
            'route_identifier_name' => 'stream_id',
            'collection_name' => 'streams',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'all',
            ),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Stream\\V1\\Rest\\Summary\\SummaryEntity',
            'collection_class' => 'Stream\\V1\\Rest\\Summary\\SummaryCollection',
            'service_name' => 'Summary',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Stream\\V1\\Rest\\Stream\\Controller' => 'HalJson',
            'Stream\\V1\\Rest\\Summary\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Stream\\V1\\Rest\\Stream\\Controller' => array(
                0 => 'application/vnd.stream.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Stream\\V1\\Rest\\Summary\\Controller' => array(
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
            'Stream\\V1\\Rest\\Summary\\Controller' => array(
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
            'Stream\\Model\\Stream' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'stream.rest.stream',
                'route_identifier_name' => 'stream_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Stream\\V1\\Rest\\Summary\\SummaryEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'stream.rest.summary',
                'route_identifier_name' => 'stream_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Stream\\V1\\Rest\\Summary\\SummaryCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'stream.rest.summary',
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
    'zf-content-validation' => array(
        'Stream\\V1\\Rest\\Stream\\Controller' => array(
            'input_filter' => 'Stream\\V1\\Rest\\Stream\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Stream\\V1\\Rest\\Stream\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Application\\Validator\\UuidV4',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'channel_id',
                'description' => 'The stream channel reference',
            ),
            1 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'title',
                'description' => 'The stream title',
            ),
            2 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Application\\Validator\\UuidV4',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'topic_id',
                'description' => 'The stream topic reference',
            ),
            3 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'topic',
                'description' => 'The stream topic',
            ),
        ),
    ),
    'validator_metadata' => array(
        'Application\\Validator\\UuidV4' => array(),
    ),
);
