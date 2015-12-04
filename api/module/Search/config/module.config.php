<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Search\\V1\\Rest\\Search\\SearchResource' => 'Search\\V1\\Rest\\Search\\SearchResourceFactory',
            'Search\\V1\\Rest\\User\\UserResource' => 'Search\\V1\\Rest\\User\\UserResourceFactory',
            'Search\\V1\\Rest\\Channel\\ChannelResource' => 'Search\\V1\\Rest\\Channel\\ChannelResourceFactory',
            'Search\\V1\\Rest\\Stream\\StreamResource' => 'Search\\V1\\Rest\\Stream\\StreamResourceFactory',
            'Search\\V1\\Rest\\Topic\\TopicResource' => 'Search\\V1\\Rest\\Topic\\TopicResourceFactory',
            'Search\\V1\\Rest\\Video\\VideoResource' => 'Search\\V1\\Rest\\Video\\VideoResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'search.rest.search' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/search',
                    'defaults' => array(
                        'controller' => 'Search\\V1\\Rest\\Search\\Controller',
                    ),
                ),
            ),
            'search.rest.user' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/search/users',
                    'defaults' => array(
                        'controller' => 'Search\\V1\\Rest\\User\\Controller',
                    ),
                ),
            ),
            'search.rest.channel' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/search/channels',
                    'defaults' => array(
                        'controller' => 'Search\\V1\\Rest\\Channel\\Controller',
                    ),
                ),
            ),
            'search.rest.stream' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/search/streams',
                    'defaults' => array(
                        'controller' => 'Search\\V1\\Rest\\Stream\\Controller',
                    ),
                ),
            ),
            'search.rest.topic' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/search/topics',
                    'defaults' => array(
                        'controller' => 'Search\\V1\\Rest\\Topic\\Controller',
                    ),
                ),
            ),
            'search.rest.video' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/search/videos',
                    'defaults' => array(
                        'controller' => 'Search\\V1\\Rest\\Video\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'search.rest.search',
            1 => 'search.rest.user',
            2 => 'search.rest.channel',
            3 => 'search.rest.stream',
            4 => 'search.rest.topic',
            5 => 'search.rest.video',
        ),
    ),
    'zf-rest' => array(
        'Search\\V1\\Rest\\Search\\Controller' => array(
            'listener' => 'Search\\V1\\Rest\\Search\\SearchResource',
            'route_name' => 'search.rest.search',
            'route_identifier_name' => 'search_id',
            'collection_name' => 'results',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'q',
                1 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Search\\V1\\Rest\\Search\\SearchEntity',
            'collection_class' => 'Search\\V1\\Rest\\Search\\SearchCollection',
            'service_name' => 'Search',
        ),
        'Search\\V1\\Rest\\User\\Controller' => array(
            'listener' => 'Search\\V1\\Rest\\User\\UserResource',
            'route_name' => 'search.rest.user',
            'route_identifier_name' => 'user_id',
            'collection_name' => 'users',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'query',
                1 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Search\\V1\\Rest\\User\\UserEntity',
            'collection_class' => 'Search\\V1\\Rest\\User\\UserCollection',
            'service_name' => 'User',
        ),
        'Search\\V1\\Rest\\Channel\\Controller' => array(
            'listener' => 'Search\\V1\\Rest\\Channel\\ChannelResource',
            'route_name' => 'search.rest.channel',
            'route_identifier_name' => 'channel_id',
            'collection_name' => 'channels',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'query',
                1 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Search\\V1\\Rest\\Channel\\ChannelEntity',
            'collection_class' => 'Search\\V1\\Rest\\Channel\\ChannelCollection',
            'service_name' => 'Channel',
        ),
        'Search\\V1\\Rest\\Stream\\Controller' => array(
            'listener' => 'Search\\V1\\Rest\\Stream\\StreamResource',
            'route_name' => 'search.rest.stream',
            'route_identifier_name' => 'stream_id',
            'collection_name' => 'streams',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'query',
                1 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Search\\V1\\Rest\\Stream\\StreamEntity',
            'collection_class' => 'Search\\V1\\Rest\\Stream\\StreamCollection',
            'service_name' => 'Stream',
        ),
        'Search\\V1\\Rest\\Topic\\Controller' => array(
            'listener' => 'Search\\V1\\Rest\\Topic\\TopicResource',
            'route_name' => 'search.rest.topic',
            'route_identifier_name' => 'topic_id',
            'collection_name' => 'topics',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'query',
                1 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Search\\V1\\Rest\\Topic\\TopicEntity',
            'collection_class' => 'Search\\V1\\Rest\\Topic\\TopicCollection',
            'service_name' => 'Topic',
        ),
        'Search\\V1\\Rest\\Video\\Controller' => array(
            'listener' => 'Search\\V1\\Rest\\Video\\VideoResource',
            'route_name' => 'search.rest.video',
            'route_identifier_name' => 'video_id',
            'collection_name' => 'videos',
            'entity_http_methods' => array(),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'query',
                1 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Search\\V1\\Rest\\Video\\VideoEntity',
            'collection_class' => 'Search\\V1\\Rest\\Video\\VideoCollection',
            'service_name' => 'Video',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Search\\V1\\Rest\\Search\\Controller' => 'HalJson',
            'Search\\V1\\Rest\\User\\Controller' => 'HalJson',
            'Search\\V1\\Rest\\Channel\\Controller' => 'HalJson',
            'Search\\V1\\Rest\\Stream\\Controller' => 'HalJson',
            'Search\\V1\\Rest\\Topic\\Controller' => 'HalJson',
            'Search\\V1\\Rest\\Video\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Search\\V1\\Rest\\Search\\Controller' => array(
                0 => 'application/vnd.search.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Search\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.search.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Search\\V1\\Rest\\Channel\\Controller' => array(
                0 => 'application/vnd.search.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Search\\V1\\Rest\\Stream\\Controller' => array(
                0 => 'application/vnd.search.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Search\\V1\\Rest\\Topic\\Controller' => array(
                0 => 'application/vnd.search.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Search\\V1\\Rest\\Video\\Controller' => array(
                0 => 'application/vnd.search.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Search\\V1\\Rest\\Search\\Controller' => array(
                0 => 'application/vnd.search.v1+json',
                1 => 'application/json',
            ),
            'Search\\V1\\Rest\\User\\Controller' => array(
                0 => 'application/vnd.search.v1+json',
                1 => 'application/json',
            ),
            'Search\\V1\\Rest\\Channel\\Controller' => array(
                0 => 'application/vnd.search.v1+json',
                1 => 'application/json',
            ),
            'Search\\V1\\Rest\\Stream\\Controller' => array(
                0 => 'application/vnd.search.v1+json',
                1 => 'application/json',
            ),
            'Search\\V1\\Rest\\Topic\\Controller' => array(
                0 => 'application/vnd.search.v1+json',
                1 => 'application/json',
            ),
            'Search\\V1\\Rest\\Video\\Controller' => array(
                0 => 'application/vnd.search.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Search\\V1\\Rest\\Search\\SearchEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'search.rest.search',
                'route_identifier_name' => 'search_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Search\\V1\\Rest\\Search\\SearchCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'search.rest.search',
                'route_identifier_name' => 'search_id',
                'is_collection' => true,
            ),
            'Search\\V1\\Rest\\User\\UserEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'search.rest.user',
                'route_identifier_name' => 'user_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Search\\V1\\Rest\\User\\UserCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'search.rest.user',
                'route_identifier_name' => 'user_id',
                'is_collection' => true,
            ),
            'Search\\V1\\Rest\\Channel\\ChannelEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'search.rest.channel',
                'route_identifier_name' => 'channel_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Search\\V1\\Rest\\Channel\\ChannelCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'search.rest.channel',
                'route_identifier_name' => 'channel_id',
                'is_collection' => true,
            ),
            'Search\\V1\\Rest\\Stream\\StreamEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'search.rest.stream',
                'route_identifier_name' => 'stream_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Search\\V1\\Rest\\Stream\\StreamCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'search.rest.stream',
                'route_identifier_name' => 'stream_id',
                'is_collection' => true,
            ),
            'Search\\V1\\Rest\\Topic\\TopicEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'search.rest.topic',
                'route_identifier_name' => 'topic_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Search\\V1\\Rest\\Topic\\TopicCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'search.rest.topic',
                'route_identifier_name' => 'topic_id',
                'is_collection' => true,
            ),
            'Search\\V1\\Rest\\Video\\VideoEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'search.rest.video',
                'route_identifier_name' => 'video_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Search\\V1\\Rest\\Video\\VideoCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'search.rest.video',
                'route_identifier_name' => 'video_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-content-validation' => array(
        'Search\\V1\\Rest\\Search\\Controller' => array(
            'input_filter' => 'Search\\V1\\Rest\\Search\\Validator',
        ),
    ),
    'input_filter_specs' => array(
        'Search\\V1\\Rest\\Search\\Validator' => array(
            0 => array(
                'required' => true,
                'validators' => array(
                    0 => array(
                        'name' => 'Zend\\Validator\\StringLength',
                        'options' => array(
                            'min' => '3',
                        ),
                    ),
                ),
                'filters' => array(),
                'name' => 'q',
                'description' => 'The url-encoded search query',
                'error_message' => 'The search query must be at least 3 characters long',
            ),
        ),
    ),
);
