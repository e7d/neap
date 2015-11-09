<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'User\\Model\\UserModel' => 'User\\Model\\UserModelFactory',
            'User\\Model\\UserTableGateway' => 'User\\Model\\UserTableGatewayFactory',
            'User\\Service\\UserHydratorService' => 'User\\Service\\UserHydratorServiceFactory',
            'User\\Service\\UserService' => 'User\\Service\\UserServiceFactory',
            'User\\V1\\Rest\\User\\UserResource' => 'User\\V1\\Rest\\User\\UserResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'user.rpc.profile' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/profile',
                    'defaults' => array(
                        'controller' => 'User\\V1\\Rpc\\Profile\\Controller',
                        'action' => 'profile',
                    ),
                ),
            ),
            'user.rest.user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/users[/:user_id]',
                    'defaults' => array(
                        'controller' => 'User\\V1\\Rest\\User\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'user.rpc.profile',
            1 => 'user.rest.user',
        ),
    ),
    'zf-rest' => array(
        'User\\V1\\Rest\\User\\Controller' => array(
            'listener' => 'User\\V1\\Rest\\User\\UserResource',
            'route_name' => 'user.rest.user',
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
            'collection_query_whitelist' => array(
                0 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'User\\V1\\Rest\\User\\UserEntity',
            'collection_class' => 'User\\V1\\Rest\\User\\UserCollection',
            'service_name' => 'User',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'User\\V1\\Rpc\\Profile\\Controller' => 'HalJson',
            'User\\V1\\Rest\\User\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'User\\V1\\Rpc\\Profile\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ),
            'User\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'User\\V1\\Rpc\\Profile\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ),
            'User\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'User\\V1\\Rest\\User\\UserEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'User\\V1\\Rest\\User\\UserCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.user',
                'route_identifier_name' => 'user_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
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
            'User\\V1\\Rest\\User\\Controller' => array(
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
