<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Outage\\V1\\Service\\OutageService' => 'Outage\\V1\\Service\\OutageServiceFactory',
            'Outage\\V1\\Rest\\Outage\\OutageResource' => 'Outage\\V1\\Rest\\Outage\\OutageResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'outage.rest.outage' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/outages[/:outage_id]',
                    'defaults' => array(
                        'controller' => 'Outage\\V1\\Rest\\Outage\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'outage.rest.outage',
        ),
    ),
    'zf-rest' => array(
        'Outage\\V1\\Rest\\Outage\\Controller' => array(
            'listener' => 'Outage\\V1\\Rest\\Outage\\OutageResource',
            'route_name' => 'outage.rest.outage',
            'route_identifier_name' => 'outage_id',
            'collection_name' => 'outages',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'limit',
            ),
            'page_size' => '10',
            'page_size_param' => 'limit',
            'entity_class' => 'Outage\\V1\\Rest\\Outage\\OutageEntity',
            'collection_class' => 'Outage\\V1\\Rest\\Outage\\OutageCollection',
            'service_name' => 'Outage',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Outage\\V1\\Rest\\Outage\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Outage\\V1\\Rest\\Outage\\Controller' => array(
                0 => 'application/vnd.outage.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Outage\\V1\\Rest\\Outage\\Controller' => array(
                0 => 'application/vnd.outage.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Outage\\V1\\Rest\\Outage\\OutageEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'outage.rest.outage',
                'route_identifier_name' => 'outage_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Outage\\V1\\Rest\\Outage\\OutageCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'outage.rest.outage',
                'route_identifier_name' => 'outage_id',
                'is_collection' => true,
            ),
        ),
    ),
);
