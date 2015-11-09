<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Channel\\Service\\ChannelService' => 'Channel\\Service\\ChannelServiceFactory',
            'Channel\\V1\\Rest\\Channel\\ChannelResource' => 'Channel\\V1\\Rest\\Channel\\ChannelResourceFactory',
            'Channel\\V1\\Rest\\Follow\\FollowResource' => 'Channel\\V1\\Rest\\Follow\\FollowResourceFactory',
            'Channel\\V1\\Rest\\Video\\VideoResource' => 'Channel\\V1\\Rest\\Video\\VideoResourceFactory',
            'Channel\\V1\\Rest\\StreamKey\\StreamKeyResource' => 'Channel\\V1\\Rest\\StreamKey\\StreamKeyResourceFactory',
            'Channel\\V1\\Rest\\UserChannel\\UserChannelResource' => 'Channel\\V1\\Rest\\UserChannel\\UserChannelResourceFactory',
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
                    'route' => '/channels/:channel_id/follows[/:user_id]',
                    'defaults' => array(
                        'controller' => 'Channel\\V1\\Rest\\Follow\\Controller',
                    ),
                ),
            ),
            'channel.rest.video' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/channels/:channel_id/videos[/:video_id]',
                    'defaults' => array(
                        'controller' => 'Channel\\V1\\Rest\\Video\\Controller',
                    ),
                ),
            ),
            'channel.rest.stream-key' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/channels/:channel_id/stream_key',
                    'defaults' => array(
                        'controller' => 'Channel\\V1\\Rest\\StreamKey\\Controller',
                    ),
                ),
            ),
            'channel.rest.user-channel' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/channel',
                    'defaults' => array(
                        'controller' => 'Channel\\V1\\Rest\\UserChannel\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'channel.rest.channel',
            1 => 'channel.rest.follow',
            2 => 'channel.rest.video',
            3 => 'channel.rest.stream-key',
            4 => 'channel.rest.user-channel',
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
            'collection_query_whitelist' => array(
                0 => 'limit',
            ),
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
            'collection_query_whitelist' => array(
                0 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Channel\\V1\\Rest\\Follow\\FollowEntity',
            'collection_class' => 'Channel\\V1\\Rest\\Follow\\FollowCollection',
            'service_name' => 'Follow',
        ),
        'Channel\\V1\\Rest\\Video\\Controller' => array(
            'listener' => 'Channel\\V1\\Rest\\Video\\VideoResource',
            'route_name' => 'channel.rest.video',
            'route_identifier_name' => 'video_id',
            'collection_name' => 'videos',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Channel\\V1\\Rest\\Video\\VideoEntity',
            'collection_class' => 'Channel\\V1\\Rest\\Video\\VideoCollection',
            'service_name' => 'Video',
        ),
        'Channel\\V1\\Rest\\StreamKey\\Controller' => array(
            'listener' => 'Channel\\V1\\Rest\\StreamKey\\StreamKeyResource',
            'route_name' => 'channel.rest.stream-key',
            'route_identifier_name' => 'channel_id',
            'collection_name' => 'channels',
            'entity_http_methods' => array(
                0 => 'DELETE',
                1 => 'GET',
            ),
            'collection_http_methods' => array(),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Channel\\V1\\Rest\\StreamKey\\StreamKeyEntity',
            'collection_class' => 'Channel\\V1\\Rest\\StreamKey\\StreamKeyCollection',
            'service_name' => 'StreamKey',
        ),
        'Channel\\V1\\Rest\\UserChannel\\Controller' => array(
            'listener' => 'Channel\\V1\\Rest\\UserChannel\\UserChannelResource',
            'route_name' => 'channel.rest.user-channel',
            'route_identifier_name' => 'user_channel_id',
            'collection_name' => 'channels',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Channel\\V1\\Rest\\UserChannel\\UserChannelEntity',
            'collection_class' => 'Channel\\V1\\Rest\\UserChannel\\UserChannelCollection',
            'service_name' => 'UserChannel',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Channel\\V1\\Rest\\Channel\\Controller' => 'HalJson',
            'Channel\\V1\\Rest\\Follow\\Controller' => 'HalJson',
            'Channel\\V1\\Rest\\Video\\Controller' => 'HalJson',
            'Channel\\V1\\Rest\\StreamKey\\Controller' => 'HalJson',
            'Channel\\V1\\Rest\\UserChannel\\Controller' => 'HalJson',
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
            'Channel\\V1\\Rest\\Video\\Controller' => array(
                0 => 'application/vnd.channel.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Channel\\V1\\Rest\\StreamKey\\Controller' => array(
                0 => 'application/vnd.channel.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Channel\\V1\\Rest\\UserChannel\\Controller' => array(
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
            'Channel\\V1\\Rest\\Video\\Controller' => array(
                0 => 'application/vnd.channel.v1+json',
                1 => 'application/json',
            ),
            'Channel\\V1\\Rest\\StreamKey\\Controller' => array(
                0 => 'application/vnd.channel.v1+json',
                1 => 'application/json',
            ),
            'Channel\\V1\\Rest\\UserChannel\\Controller' => array(
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
            'Channel\\V1\\Rest\\Video\\VideoEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.video',
                'route_identifier_name' => 'video_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Channel\\V1\\Rest\\Video\\VideoCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.video',
                'route_identifier_name' => 'video_id',
                'is_collection' => true,
            ),
            'Channel\\V1\\Rest\\StreamKey\\StreamKeyEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.stream-key',
                'route_identifier_name' => 'channel_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Channel\\V1\\Rest\\StreamKey\\StreamKeyCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.stream-key',
                'route_identifier_name' => 'channel_id',
                'is_collection' => true,
            ),
            'Channel\\V1\\Rest\\UserChannel\\UserChannelEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.user-channel',
                'route_identifier_name' => 'user_channel_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Channel\\V1\\Rest\\UserChannel\\UserChannelCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'channel.rest.user-channel',
                'route_identifier_name' => 'user_channel_id',
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
            'Channel\\V1\\Rest\\StreamKey\\Controller' => array(
                'collection' => array(
                    'GET' => false,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ),
                'entity' => array(
                    'GET' => true,
                    'POST' => false,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => true,
                ),
            ),
            'Channel\\V1\\Rest\\UserChannel\\Controller' => array(
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
        ),
    ),
    'controllers' => array(
        'factories' => array(),
    ),
    'zf-rpc' => array(),
    'zf-content-validation' => array(
        'Channel\\V1\\Rest\\Channel\\Controller' => array(
            'input_filter' => 'Channel\\V1\\Rest\\Channel\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Channel\\V1\\Rest\\Channel\\Validator' => array(
            0 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Application\\Validator\\UuidV4',
                        'options' => array(),
                    ),
                ),
                'filters' => array(),
                'name' => 'topic_id',
                'description' => 'The channel topic identifier',
                'error_message' => 'The topic_id must be a valid UUID',
            ),
            1 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'max' => '64',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'topic',
                'description' => 'The channel topic',
                'error_message' => 'The topic must be defined',
            ),
            2 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => '2',
                            'max' => '2',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'language',
                'description' => 'The language spoken by the broadcaster',
                'error_message' => 'The language must be a valid 2 characters language code',
            ),
            3 => array(
                'required' => true,
                'validators' => array(),
                'filters' => array(),
                'name' => 'delay',
                'description' => 'The delay, in seconds, between the stream recording and the actual playback',
                'error_message' => 'The delay must be an integer between 0 and 120.',
            ),
            4 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Uri',
                        'options' => array(
                            'allowAbsolute' => true,
                            'allowRelative' => '',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'logo',
                'description' => 'The channel logo URI',
                'error_message' => 'The logo must be a valid URI',
            ),
            5 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Uri',
                        'options' => array(
                            'allowAbsolute' => true,
                            'allowRelative' => '',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'banner',
                'description' => 'The channel banner URI',
                'error_message' => 'The banner must be a valid URI',
            ),
            6 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Uri',
                        'options' => array(
                            'allowAbsolute' => true,
                            'allowRelative' => '',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'video_banner',
                'description' => 'The channel video banner URI',
                'error_message' => 'The video_banner must be a valid URI',
            ),
            7 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Uri',
                        'options' => array(
                            'allowAbsolute' => true,
                            'allowRelative' => '',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'background',
                'description' => 'The channel background URI',
                'error_message' => 'The background must be a valid URI',
            ),
            8 => array(
                'required' => false,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\Uri',
                        'options' => array(
                            'allowAbsolute' => true,
                            'allowRelative' => '',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'profile_banner',
                'description' => 'The channel profile banner URI',
                'error_message' => 'The profile_banner must be a valid URI',
            ),
        ),
    ),
);
