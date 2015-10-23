<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Channel\\Service\\ChannelService' => 'Channel\\Service\\ChannelServiceFactory',
            'Channel\\V1\\Rest\\Channel\\ChannelResource' => 'Channel\\V1\\Rest\\Channel\\ChannelResourceFactory',
            'Channel\\V1\\Rest\\Follows\\FollowsResource' => 'Channel\\V1\\Rest\\Follows\\FollowsResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'channel.rest.channel' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/channels[/:channel_id]',
                    'defaults' => array(
                        'controller' => 'Channel\\V1\\Rest\\Channel\\Controller',
                    ),
                ),
            ),
            'channel.rest.follows' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/channels/:channel_id/follows[/:follow_id]',
                    'defaults' => array(
                        'controller' => 'Channel\\V1\\Rest\\Follows\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'channel.rest.channel',
            1 => 'channel.rest.follows',
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
        'Channel\\V1\\Rest\\Follows\\Controller' => array(
            'listener' => 'Channel\\V1\\Rest\\Follows\\FollowsResource',
            'route_name' => 'channel.rest.follows',
            'route_identifier_name' => 'follow_id',
            'collection_name' => 'follows',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Channel\\V1\\Rest\\Follows\\FollowsEntity',
            'collection_class' => 'Channel\\V1\\Rest\\Follows\\FollowsCollection',
            'service_name' => 'Follows',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Channel\\V1\\Rest\\Channel\\Controller' => 'HalJson',
            'Channel\\V1\\Rest\\Follows\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Channel\\V1\\Rest\\Channel\\Controller' => array(
                0 => 'application/vnd.channel.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Channel\\V1\\Rest\\Follows\\Controller' => array(
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
            'Channel\\V1\\Rest\\Follows\\Controller' => array(
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
            'Channel\\V1\\Rest\\Follows\\FollowsEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.follows',
                'route_identifier_name' => 'follow_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Channel\\V1\\Rest\\Follows\\FollowsCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.follows',
                'route_identifier_name' => 'follow_id',
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
        ),
    ),
);
