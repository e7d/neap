<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'User\\V1\\Rest\\User\\UserResource' => 'User\\V1\\Rest\\User\\UserResourceFactory',
            'User\\V1\\Service\\UserService' => 'User\\V1\\Service\\UserServiceFactory',
            'User\\V1\\Rest\\Follow\\FollowResource' => 'User\\V1\\Rest\\Follow\\FollowResourceFactory',
            'User\\V1\\Rest\\MyUser\\MyUserResource' => 'User\\V1\\Rest\\MyUser\\MyUserResourceFactory',
            'User\\V1\\Rest\\Block\\BlockResource' => 'User\\V1\\Rest\\Block\\BlockResourceFactory',
            'User\\V1\\Rest\\Mod\\ModResource' => 'User\\V1\\Rest\\Mod\\ModResourceFactory',
            'User\\V1\\Rest\\Favorite\\FavoriteResource' => 'User\\V1\\Rest\\Favorite\\FavoriteResourceFactory',
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
            'user.rest.follow' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/users/:user_id/follows[/:channel_id]',
                    'defaults' => array(
                        'controller' => 'User\\V1\\Rest\\Follow\\Controller',
                    ),
                ),
            ),
            'user.rest.my-user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/user',
                    'defaults' => array(
                        'controller' => 'User\\V1\\Rest\\MyUser\\Controller',
                    ),
                ),
            ),
            'user.rest.block' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/users/:user_id/blocks[/:target_user_id]',
                    'defaults' => array(
                        'controller' => 'User\\V1\\Rest\\Block\\Controller',
                    ),
                ),
            ),
            'user.rest.mod' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => 'users/:user_id/mods[/:chat_id]',
                    'defaults' => array(
                        'controller' => 'User\\V1\\Rest\\Mod\\Controller',
                    ),
                ),
            ),
            'user.rest.favorite' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/users/:user_id/favorites[/:favorite_id]',
                    'defaults' => array(
                        'controller' => 'User\\V1\\Rest\\Favorite\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'user.rpc.profile',
            1 => 'user.rest.user',
            2 => 'user.rest.follow',
            3 => 'user.rest.my-user',
            4 => 'user.rest.block',
            5 => 'user.rest.mod',
            6 => 'user.rest.favorite',
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
        'User\\V1\\Rest\\Follow\\Controller' => array(
            'listener' => 'User\\V1\\Rest\\Follow\\FollowResource',
            'route_name' => 'user.rest.follow',
            'route_identifier_name' => 'follow_id',
            'collection_name' => 'follows',
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
            'entity_class' => 'User\\V1\\Rest\\Follow\\FollowEntity',
            'collection_class' => 'User\\V1\\Rest\\Follow\\FollowCollection',
            'service_name' => 'Follow',
        ),
        'User\\V1\\Rest\\MyUser\\Controller' => array(
            'listener' => 'User\\V1\\Rest\\MyUser\\MyUserResource',
            'route_name' => 'user.rest.my-user',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'users',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'User\\V1\\Rest\\MyUser\\MyUserEntity',
            'collection_class' => 'User\\V1\\Rest\\MyUser\\MyUserCollection',
            'service_name' => 'MyUser',
        ),
        'User\\V1\\Rest\\Block\\Controller' => array(
            'listener' => 'User\\V1\\Rest\\Block\\BlockResource',
            'route_name' => 'user.rest.block',
            'route_identifier_name' => 'target_user_id',
            'collection_name' => 'blocks',
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
            'entity_class' => 'User\\V1\\Rest\\Block\\BlockEntity',
            'collection_class' => 'User\\V1\\Rest\\Block\\BlockCollection',
            'service_name' => 'Block',
        ),
        'User\\V1\\Rest\\Mod\\Controller' => array(
            'listener' => 'User\\V1\\Rest\\Mod\\ModResource',
            'route_name' => 'user.rest.mod',
            'route_identifier_name' => 'chat_id',
            'collection_name' => 'mods',
            'entity_http_methods' => array(
                0 => 'PUT',
                1 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'User\\V1\\Rest\\Mod\\ModEntity',
            'collection_class' => 'User\\V1\\Rest\\Mod\\ModCollection',
            'service_name' => 'Mod',
        ),
        'User\\V1\\Rest\\Favorite\\Controller' => array(
            'listener' => 'User\\V1\\Rest\\Favorite\\FavoriteResource',
            'route_name' => 'user.rest.favorite',
            'route_identifier_name' => 'favorite_id',
            'collection_name' => 'favorites',
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
            'entity_class' => 'User\\V1\\Rest\\Favorite\\FavoriteEntity',
            'collection_class' => 'User\\V1\\Rest\\Favorite\\FavoriteCollection',
            'service_name' => 'Favorite',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'User\\V1\\Rpc\\Profile\\Controller' => 'HalJson',
            'User\\V1\\Rest\\User\\Controller' => 'HalJson',
            'User\\V1\\Rest\\Follow\\Controller' => 'HalJson',
            'User\\V1\\Rest\\MyUser\\Controller' => 'HalJson',
            'User\\V1\\Rest\\Block\\Controller' => 'HalJson',
            'User\\V1\\Rest\\Mod\\Controller' => 'HalJson',
            'User\\V1\\Rest\\Favorite\\Controller' => 'HalJson',
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
            'User\\V1\\Rest\\Follow\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'User\\V1\\Rest\\MyUser\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'User\\V1\\Rest\\Block\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'User\\V1\\Rest\\Mod\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'User\\V1\\Rest\\Favorite\\Controller' => array(
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
            'User\\V1\\Rest\\Follow\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ),
            'User\\V1\\Rest\\MyUser\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ),
            'User\\V1\\Rest\\Block\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ),
            'User\\V1\\Rest\\Mod\\Controller' => array(
                0 => 'application/vnd.user.v1+json',
                1 => 'application/json',
            ),
            'User\\V1\\Rest\\Favorite\\Controller' => array(
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
            'User\\V1\\Rest\\Follow\\FollowEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.follow',
                'route_identifier_name' => 'follow_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'User\\V1\\Rest\\Follow\\FollowCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.follow',
                'route_identifier_name' => 'follow_id',
                'is_collection' => true,
            ),
            'User\\V1\\Rest\\MyUser\\MyUserEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.my-user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'User\\V1\\Rest\\MyUser\\MyUserCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.my-user',
                'route_identifier_name' => 'user_id',
                'is_collection' => true,
            ),
            'User\\V1\\Rest\\Block\\BlockEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.block',
                'route_identifier_name' => 'target_user_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'User\\V1\\Rest\\Block\\BlockCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.block',
                'route_identifier_name' => 'target_user_id',
                'is_collection' => true,
            ),
            'User\\V1\\Rest\\Mod\\ModEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.mod',
                'route_identifier_name' => 'chat_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'User\\V1\\Rest\\Mod\\ModCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.mod',
                'route_identifier_name' => 'chat_id',
                'is_collection' => true,
            ),
            'User\\V1\\Rest\\Favorite\\FavoriteEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.favorite',
                'route_identifier_name' => 'favorite_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ArraySerializable',
            ),
            'User\\V1\\Rest\\Favorite\\FavoriteCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'user.rest.favorite',
                'route_identifier_name' => 'favorite_id',
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
            'User\\V1\\Rest\\Follow\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => false,
                    'DELETE' => true,
                ),
            ),
            'User\\V1\\Rest\\MyUser\\Controller' => array(
                'collection' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
            ),
            'User\\V1\\Rest\\Block\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => false,
                    'DELETE' => true,
                ),
            ),
            'User\\V1\\Rest\\Mod\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => false,
                    'DELETE' => true,
                ),
            ),
            'User\\V1\\Rest\\Favorite\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => false,
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
