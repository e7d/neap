<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Video\\V1\\Service\\VideoService' => 'Video\\V1\\Service\\VideoServiceFactory',
            'Video\\V1\\Rest\\Video\\VideoResource' => 'Video\\V1\\Rest\\Video\\VideoResourceFactory',
            'Video\\V1\\Rest\\Favorite\\FavoriteResource' => 'Video\\V1\\Rest\\Favorite\\FavoriteResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'video.rest.video' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/videos[/:video_id]',
                    'defaults' => array(
                        'controller' => 'Video\\V1\\Rest\\Video\\Controller',
                    ),
                ),
            ),
            'video.rest.favorite' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/videos/:video_id/favorites[/:favorite_id]',
                    'defaults' => array(
                        'controller' => 'Video\\V1\\Rest\\Favorite\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'video.rest.video',
            1 => 'video.rest.favorite',
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
            'collection_query_whitelist' => array(
                0 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Video\\V1\\Rest\\Video\\VideoEntity',
            'collection_class' => 'Video\\V1\\Rest\\Video\\VideoCollection',
            'service_name' => 'Video',
        ),
        'Video\\V1\\Rest\\Favorite\\Controller' => array(
            'listener' => 'Video\\V1\\Rest\\Favorite\\FavoriteResource',
            'route_name' => 'video.rest.favorite',
            'route_identifier_name' => 'favorite_id',
            'collection_name' => 'favorites',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Video\\V1\\Rest\\Favorite\\FavoriteEntity',
            'collection_class' => 'Video\\V1\\Rest\\Favorite\\FavoriteCollection',
            'service_name' => 'Favorite',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Video\\V1\\Rest\\Video\\Controller' => 'HalJson',
            'Video\\V1\\Rest\\Favorite\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Video\\V1\\Rest\\Video\\Controller' => array(
                0 => 'application/vnd.video.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Video\\V1\\Rest\\Favorite\\Controller' => array(
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
            'Video\\V1\\Rest\\Favorite\\Controller' => array(
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
            'Video\\V1\\Rest\\Favorite\\FavoriteEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'video.rest.favorite',
                'route_identifier_name' => 'favorite_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Video\\V1\\Rest\\Favorite\\FavoriteCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'video.rest.favorite',
                'route_identifier_name' => 'favorite_id',
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
