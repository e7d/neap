<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Ingest\\V1\\Rest\\Ingest\\IngestResource' => 'Ingest\\V1\\Rest\\Ingest\\IngestResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'ingest.rest.ingest' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/ingests[/:ingest_id]',
                    'defaults' => array(
                        'controller' => 'Ingest\\V1\\Rest\\Ingest\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'ingest.rest.ingest',
        ),
    ),
    'zf-rest' => array(
        'Ingest\\V1\\Rest\\Ingest\\Controller' => array(
            'listener' => 'Ingest\\V1\\Rest\\Ingest\\IngestResource',
            'route_name' => 'ingest.rest.ingest',
            'route_identifier_name' => 'ingest_id',
            'collection_name' => 'ingests',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Ingest\\V1\\Rest\\Ingest\\IngestEntity',
            'collection_class' => 'Ingest\\V1\\Rest\\Ingest\\IngestCollection',
            'service_name' => 'Ingest',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Ingest\\V1\\Rest\\Ingest\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Ingest\\V1\\Rest\\Ingest\\Controller' => array(
                0 => 'application/vnd.ingest.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Ingest\\V1\\Rest\\Ingest\\Controller' => array(
                0 => 'application/vnd.ingest.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Ingest\\V1\\Rest\\Ingest\\IngestEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'ingest.rest.ingest',
                'route_identifier_name' => 'ingest_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Ingest\\V1\\Rest\\Ingest\\IngestCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'ingest.rest.ingest',
                'route_identifier_name' => 'ingest_id',
                'is_collection' => true,
            ),
        ),
    ),
);
