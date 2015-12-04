<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Emoji\\V1\\Rest\\Emoji\\EmojiResource' => 'Emoji\\V1\\Rest\\Emoji\\EmojiResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'emoji.rest.emoji' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/emojis[/:emoji_id]',
                    'defaults' => array(
                        'controller' => 'Emoji\\V1\\Rest\\Emoji\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'emoji.rest.emoji',
        ),
    ),
    'zf-rest' => array(
        'Emoji\\V1\\Rest\\Emoji\\Controller' => array(
            'listener' => 'Emoji\\V1\\Rest\\Emoji\\EmojiResource',
            'route_name' => 'emoji.rest.emoji',
            'route_identifier_name' => 'emoji_id',
            'collection_name' => 'emojis',
            'entity_http_methods' => array(
                0 => 'GET',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'limit',
            ),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Emoji\\V1\\Rest\\Emoji\\EmojiEntity',
            'collection_class' => 'Emoji\\V1\\Rest\\Emoji\\EmojiCollection',
            'service_name' => 'Emoji',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Emoji\\V1\\Rest\\Emoji\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Emoji\\V1\\Rest\\Emoji\\Controller' => array(
                0 => 'application/vnd.emoji.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Emoji\\V1\\Rest\\Emoji\\Controller' => array(
                0 => 'application/vnd.emoji.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Emoji\\V1\\Rest\\Emoji\\EmojiEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'emoji.rest.emoji',
                'route_identifier_name' => 'emoji_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Emoji\\V1\\Rest\\Emoji\\EmojiCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'emoji.rest.emoji',
                'route_identifier_name' => 'emoji_id',
                'is_collection' => true,
            ),
        ),
    ),
);
