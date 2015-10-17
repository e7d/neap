<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'User\\V1\\Rest\\Users\\UsersResource' => 'User\\V1\\Rest\\Users\\UsersResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'user.rest.users' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/users[/:user_id]',
                    'defaults' => array(
                        'controller' => 'User\\V1\\Rest\\Users\\Controller',
                    ),
                ),
            ),
            'user.rpc.profile' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/profile',
                    'defaults' => array(
                        'controller' => 'User\\V1\\Rpc\\Profile\\Controller',
                        'action' => 'profile',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            1 => 'user.rest.users',
            0 => 'user.rpc.profile',
        ),
    ),
    'zf-rest' => array(
        'User\\V1\\Rest\\Users\\Controller' => array(
            'listener' => 'User\\V1\\Rest\\Users\\UsersResource',
            'route_name' => 'user.rest.users',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'users',
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
            'entity_class' => 'User\\V1\\Rest\\Users\\UsersEntity',
            'collection_class' => 'User\\V1\\Rest\\Users\\UsersCollection',
            'service_name' => 'Users',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'User\\V1\\Rest\\Users\\Controller' => 'HalJson',
            'User\\V1\\Rpc\\Profile\\Controller' => 'Json',
        ),
        'accept_whitelist' => array(
            'User\\V1\\Rest\\Users\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'User\\V1\\Rpc\\Profile\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
        ),
        'content_type_whitelist' => array(
            'User\\V1\\Rest\\Users\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ),
            'User\\V1\\Rpc\\Profile\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'User\\V1\\Rest\\Users\\UsersEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.users',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'User\\V1\\Rest\\Users\\UsersCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.users',
                'route_identifier_name' => 'user_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'User\\V1\\Rest\\Users\\Controller' => array(
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
                    'PUT' => false,
                    'PATCH' => true,
                    'DELETE' => true,
                ),
            ),
            'User\\V1\\Rpc\\Profile\\Controller' => array(
                'actions' => array(
                    'Profile' => array(
                        'GET' => true,
                        'POST' => false,
                        'PUT' => false,
                        'PATCH' => false,
                        'DELETE' => true,
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'User\\V1\\Rpc\\Profile\\Controller' => 'User\\V1\\Rpc\\Profile\\ProfileControllerFactory',
        ),
    ),
    'zf-rpc' => array(
        'User\\V1\\Rpc\\Profile\\Controller' => array(
            'service_name' => 'Profile',
            'http_methods' => array(
                0 => 'GET',
                1 => 'DELETE',
            ),
            'route_name' => 'user.rpc.profile',
        ),
    ),
);
