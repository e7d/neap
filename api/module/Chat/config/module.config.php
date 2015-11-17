<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Chat\\V1\\Service\\ChatService' => 'Chat\\V1\\Service\\ChatServiceFactory',
            'Chat\\V1\\Rest\\Chat\\ChatResource' => 'Chat\\V1\\Rest\\Chat\\ChatResourceFactory',
            'Chat\\V1\\Rest\\Emoticon\\EmoticonResource' => 'Chat\\V1\\Rest\\Emoticon\\EmoticonResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'chat.rest.chat' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/chat[/:chat_id]',
                    'defaults' => array(
                        'controller' => 'Chat\\V1\\Rest\\Chat\\Controller',
                    ),
                ),
            ),
            'chat.rest.emoticon' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/chat/emoticons[/:emoticon_id]',
                    'defaults' => array(
                        'controller' => 'Chat\\V1\\Rest\\Emoticon\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'chat.rest.chat',
            1 => 'chat.rest.emoticon',
        ),
    ),
    'zf-rest' => array(
        'Chat\\V1\\Rest\\Chat\\Controller' => array(
            'listener' => 'Chat\\V1\\Rest\\Chat\\ChatResource',
            'route_name' => 'chat.rest.chat',
            'route_identifier_name' => 'chat_id',
            'collection_name' => 'chats',
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
            'entity_class' => 'Chat\\V1\\Rest\\Chat\\ChatEntity',
            'collection_class' => 'Chat\\V1\\Rest\\Chat\\ChatCollection',
            'service_name' => 'Chat',
        ),
        'Chat\\V1\\Rest\\Emoticon\\Controller' => array(
            'listener' => 'Chat\\V1\\Rest\\Emoticon\\EmoticonResource',
            'route_name' => 'chat.rest.emoticon',
            'route_identifier_name' => 'emoticon_id',
            'collection_name' => 'emoticons',
            'entity_http_methods' => array(
                0 => 'PUT',
                1 => 'DELETE',
            ),
            'collection_http_methods' => array(
                0 => 'GET',
            ),
            'collection_query_whitelist' => array(
                0 => 'limit',
                1 => 'chat_id',
            ),
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => 'Chat\\V1\\Rest\\Emoticon\\EmoticonEntity',
            'collection_class' => 'Chat\\V1\\Rest\\Emoticon\\EmoticonCollection',
            'service_name' => 'Emoticon',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Chat\\V1\\Rest\\Chat\\Controller' => 'HalJson',
            'Chat\\V1\\Rest\\Emoticon\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Chat\\V1\\Rest\\Chat\\Controller' => array(
                0 => 'application/vnd.chat.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
            'Chat\\V1\\Rest\\Emoticon\\Controller' => array(
                0 => 'application/vnd.chat.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Chat\\V1\\Rest\\Chat\\Controller' => array(
                0 => 'application/vnd.chat.v1+json',
                1 => 'application/json',
            ),
            'Chat\\V1\\Rest\\Emoticon\\Controller' => array(
                0 => 'application/vnd.chat.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Chat\\V1\\Rest\\Chat\\ChatEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'chat.rest.chat',
                'route_identifier_name' => 'chat_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Chat\\V1\\Rest\\Chat\\ChatCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'chat.rest.chat',
                'route_identifier_name' => 'chat_id',
                'is_collection' => true,
            ),
            'Chat\\V1\\Rest\\Emoticon\\EmoticonEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'chat.rest.emoticon',
                'route_identifier_name' => 'emoticon_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Chat\\V1\\Rest\\Emoticon\\EmoticonCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'chat.rest.emoticon',
                'route_identifier_name' => 'emoticon_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Chat\\V1\\Rest\\Chat\\Controller' => array(
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
