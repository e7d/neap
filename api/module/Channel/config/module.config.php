<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Channel\\V1\\Rest\\Channels\\ChannelsResource' => 'Channel\\V1\\Rest\\Channels\\ChannelsResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'channel.rest.channels' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/channels[/:channel_id]',
                    'defaults' => array(
                        'controller' => 'Channel\\V1\\Rest\\Channels\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            1 => 'channel.rest.channels',
        ),
    ),
    'zf-rest' => array(
        'Channel\\V1\\Rest\\Channels\\Controller' => array(
            'listener' => 'Channel\\V1\\Rest\\Channels\\ChannelsResource',
            'route_name' => 'channel.rest.channels',
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
            'entity_class' => 'Channel\\V1\\Rest\\Channels\\ChannelsEntity',
            'collection_class' => 'Channel\\V1\\Rest\\Channels\\ChannelsCollection',
            'service_name' => 'Channels',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Channel\\V1\\Rest\\Channels\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Channel\\V1\\Rest\\Channels\\Controller' => array(
                0 => 'application/vnd.channel.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Channel\\V1\\Rest\\Channels\\Controller' => array(
                0 => 'application/vnd.channel.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Channel\\V1\\Rest\\Channels\\ChannelsEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.channels',
                'route_identifier_name' => 'channel_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Channel\\V1\\Rest\\Channels\\ChannelsCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.channels',
                'route_identifier_name' => 'channel_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Channel\\V1\\Rest\\Channels\\Controller' => array(
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
