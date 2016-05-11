<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Ingest\\V1\\Service\\IngestService' => 'Ingest\\V1\\Service\\IngestServiceFactory',
            'Ingest\\V1\\Rest\\Ingest\\IngestResource' => 'Ingest\\V1\\Rest\\Ingest\\IngestResourceFactory',
            'Ingest\\V1\\Rest\\Outage\\OutageResource' => 'Ingest\\V1\\Rest\\Outage\\OutageResourceFactory',
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
            'ingest.rest.outage' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/ingests/:ingest_id/outages[/:outage_id]',
                    'defaults' => array(
                        'controller' => 'Ingest\\V1\\Rest\\Outage\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'ingest.rest.ingest',
            1 => 'ingest.rest.outage',
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
        'Ingest\\V1\\Rest\\Outage\\Controller' => array(
            'listener' => 'Ingest\\V1\\Rest\\Outage\\OutageResource',
            'route_name' => 'ingest.rest.outage',
            'route_identifier_name' => 'outage_id',
            'collection_name' => 'outages',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'limit',
            ),
            'page_size' => '10',
            'page_size_param' => 'limit',
            'entity_class' => 'Ingest\\V1\\Rest\\Outage\\OutageEntity',
            'collection_class' => 'Ingest\\V1\\Rest\\Outage\\OutageCollection',
            'service_name' => 'Outage',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Ingest\\V1\\Rest\\Ingest\\Controller' => 'HalJson',
            'Ingest\\V1\\Rest\\Outage\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Ingest\\V1\\Rest\\Ingest\\Controller' => array(
                0 => 'application/vnd.ingest.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Ingest\\V1\\Rest\\Outage\\Controller' => array(
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
            'Ingest\\V1\\Rest\\Outage\\Controller' => array(
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
            'Ingest\\V1\\Rest\\Outage\\OutageEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'ingest.rest.outage',
                'route_identifier_name' => 'outage_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Ingest\\V1\\Rest\\Outage\\OutageCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'ingest.rest.outage',
                'route_identifier_name' => 'outage_id',
                'is_collection' => true,
            ),
        ),
    ),
);
