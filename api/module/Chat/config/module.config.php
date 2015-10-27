<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Chat\\Service\\ChatService' => 'Chat\\Service\\ChatServiceFactory',
            'Chat\\V1\\Rest\\Chat\\ChatResource' => 'Chat\\V1\\Rest\\Chat\\ChatResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'chat.rest.chat' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/api/chat[/:chat_id]',
                    'defaults' => array(
                        'controller' => 'Chat\\V1\\Rest\\Chat\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'chat.rest.chat',
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
            'collection_query_whitelist' => array(),
            'page_size' => 25,
            'page_size_param' => 'limit',
            'entity_class' => 'Chat\\V1\\Rest\\Chat\\ChatEntity',
            'collection_class' => 'Chat\\V1\\Rest\\Chat\\ChatCollection',
            'service_name' => 'Chat',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Chat\\V1\\Rest\\Chat\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Chat\\V1\\Rest\\Chat\\Controller' => array(
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
