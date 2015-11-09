<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Channel\\Service\\ChannelService' => 'Channel\\Service\\ChannelServiceFactory',
            'Channel\\V1\\Rest\\Channel\\ChannelResource' => 'Channel\\V1\\Rest\\Channel\\ChannelResourceFactory',
            'Channel\\V1\\Rest\\Follow\\FollowResource' => 'Channel\\V1\\Rest\\Follow\\FollowResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'channel.rest.channel' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/channels[/:channel_id]',
                    'defaults' => array(
                        'controller' => 'Channel\\V1\\Rest\\Channel\\Controller',
                    ),
                ),
            ),
            'channel.rest.follow' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/channels/:channel_id/follows/users[/:user_id]',
                    'defaults' => array(
                        'controller' => 'Channel\\V1\\Rest\\Follow\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'channel.rest.channel',
            1 => 'channel.rest.follow',
        ),
    ),
    'zf-rest' => array(
        'Channel\\V1\\Rest\\Channel\\Controller' => array(
            'listener' => 'Channel\\V1\\Rest\\Channel\\ChannelResource',
            'route_name' => 'channel.rest.channel',
            'route_identifier_name' => 'channel_id',
            'collection_name' => 'channels',
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
            'entity_class' => 'Channel\\V1\\Rest\\Channel\\ChannelEntity',
            'collection_class' => 'Channel\\V1\\Rest\\Channel\\ChannelCollection',
            'service_name' => 'Channel',
        ),
        'Channel\\V1\\Rest\\Follow\\Controller' => array(
            'listener' => 'Channel\\V1\\Rest\\Follow\\FollowResource',
            'route_name' => 'channel.rest.follow',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'follows',
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
            'page_size_param' => null,
            'entity_class' => 'Channel\\V1\\Rest\\Follow\\FollowEntity',
            'collection_class' => 'Channel\\V1\\Rest\\Follow\\FollowCollection',
            'service_name' => 'Follow',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Channel\\V1\\Rest\\Channel\\Controller' => 'HalJson',
            'Channel\\V1\\Rest\\Follow\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Channel\\V1\\Rest\\Channel\\Controller' => array(
                0 => 'application/vnd.channel.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Channel\\V1\\Rest\\Follow\\Controller' => array(
                0 => 'application/vnd.channel.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Channel\\V1\\Rest\\Channel\\Controller' => array(
                0 => 'application/vnd.channel.v1+json',
                1 => 'application/json',
            ),
            'Channel\\V1\\Rest\\Follow\\Controller' => array(
                0 => 'application/vnd.channel.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Channel\\V1\\Rest\\Channel\\ChannelEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.channel',
                'route_identifier_name' => 'channel_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Channel\\V1\\Rest\\Channel\\ChannelCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.channel',
                'route_identifier_name' => 'channel_id',
                'is_collection' => true,
            ),
            'Channel\\V1\\Rest\\Follow\\FollowEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.follow',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Channel\\V1\\Rest\\Follow\\FollowCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.follow',
                'route_identifier_name' => 'user_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Channel\\V1\\Rest\\Channel\\Controller' => array(
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
            'Channel\\V1\\Rest\\Follow\\Controller' => array(
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
