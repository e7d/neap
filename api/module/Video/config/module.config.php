<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Video\\Model\\VideoModel' => 'Video\\Model\\VideoModelFactory',
            'Video\\Model\\VideoTableGateway' => 'Video\\Model\\VideoTableGatewayFactory',
            'Video\\Service\\VideoHydratorService' => 'Video\\Service\\VideoHydratorServiceFactory',
            'Video\\Service\\VideoService' => 'Video\\Service\\VideoServiceFactory',
            'Video\\V1\\Rest\\Video\\VideoResource' => 'Video\\V1\\Rest\\Video\\VideoResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'video.rest.video' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/videos[/:video_id]',
                    'defaults' => array(
                        'controller' => 'Video\\V1\\Rest\\Video\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'video.rest.video',
        ),
    ),
    'zf-rest' => array(
        'Video\\V1\\Rest\\Video\\Controller' => array(
            'listener' => 'Video\\V1\\Rest\\Video\\VideoResource',
            'route_name' => 'video.rest.video',
            'route_identifier_name' => 'video_id',
            'collection_name' => 'videos',
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
            'entity_class' => 'Video\\V1\\Rest\\Video\\VideoEntity',
            'collection_class' => 'Video\\V1\\Rest\\Video\\VideoCollection',
            'service_name' => 'Video',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Video\\V1\\Rest\\Video\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Video\\V1\\Rest\\Video\\Controller' => array(
                0 => 'application/vnd.video.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Video\\V1\\Rest\\Video\\Controller' => array(
                0 => 'application/vnd.video.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Video\\V1\\Rest\\Video\\VideoEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'video.rest.video',
                'route_identifier_name' => 'video_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Video\\V1\\Rest\\Video\\VideoCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'video.rest.video',
                'route_identifier_name' => 'video_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Video\\V1\\Rest\\Video\\Controller' => array(
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
