<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Team\\V1\\Rest\\Team\\TeamResource' => 'Team\\V1\\Rest\\Team\\TeamResourceFactory',
            'Team\\V1\\Rest\\User\\UserResource' => 'Team\\V1\\Rest\\User\\UserResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'team.rest.team' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/teams[/:team_id]',
                    'defaults' => array(
                        'controller' => 'Team\\V1\\Rest\\Team\\Controller',
                    ),
                ),
            ),
            'team.rest.user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/teams/:team_id/user[/:user_id]',
                    'defaults' => array(
                        'controller' => 'Team\\V1\\Rest\\User\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'team.rest.team',
            1 => 'team.rest.user',
        ),
    ),
    'zf-rest' => array(
        'Team\\V1\\Rest\\Team\\Controller' => array(
            'listener' => 'Team\\V1\\Rest\\Team\\TeamResource',
            'route_name' => 'team.rest.team',
            'route_identifier_name' => 'team_id',
            'collection_name' => 'teams',
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
            'entity_class' => 'Team\\V1\\Rest\\Team\\TeamEntity',
            'collection_class' => 'Team\\V1\\Rest\\Team\\TeamCollection',
            'service_name' => 'Team',
        ),
        'Team\\V1\\Rest\\User\\Controller' => array(
            'listener' => 'Team\\V1\\Rest\\User\\UserResource',
            'route_name' => 'team.rest.user',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'users',
            'entity_http_methods' => array(
                0 => 'PUT',
                1 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Team\\V1\\Rest\\User\\UserEntity',
            'collection_class' => 'Team\\V1\\Rest\\User\\UserCollection',
            'service_name' => 'User',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Team\\V1\\Rest\\Team\\Controller' => 'HalJson',
            'Team\\V1\\Rest\\User\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Team\\V1\\Rest\\Team\\Controller' => array(
                0 => 'application/vnd.team.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Team\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.team.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Team\\V1\\Rest\\Team\\Controller' => array(
                0 => 'application/vnd.team.v1+json',
                1 => 'application/json',
            ),
            'Team\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.team.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Team\\V1\\Rest\\Team\\TeamEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'team.rest.team',
                'route_identifier_name' => 'team_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Team\\V1\\Rest\\Team\\TeamCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'team.rest.team',
                'route_identifier_name' => 'team_id',
                'is_collection' => true,
            ),
            'Team\\V1\\Rest\\User\\UserEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'team.rest.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'Team\\V1\\Rest\\User\\UserCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'team.rest.user',
                'route_identifier_name' => 'user_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Team\\V1\\Rest\\Team\\Controller' => array(
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
