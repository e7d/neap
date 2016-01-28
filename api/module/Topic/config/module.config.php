<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Topic\\V1\\Service\\TopicService' => 'Topic\\V1\\Service\\TopicServiceFactory',
            'Topic\\V1\\Rest\\Topic\\TopicResource' => 'Topic\\V1\\Rest\\Topic\\TopicResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'topic.rest.topic' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/topics[/:topic_id]',
                    'defaults' => array(
                        'controller' => 'Topic\\V1\\Rest\\Topic\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'topic.rest.topic',
        ),
    ),
    'zf-rest' => array(
        'Topic\\V1\\Rest\\Topic\\Controller' => array(
            'listener' => 'Topic\\V1\\Rest\\Topic\\TopicResource',
            'route_name' => 'topic.rest.topic',
            'route_identifier_name' => 'topic_id',
            'collection_name' => 'topics',
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
                1 => 'top',
            ),
            'page_size' => '10',
            'page_size_param' => 'limit',
            'entity_class' => 'Topic\\V1\\Rest\\Topic\\TopicEntity',
            'collection_class' => 'Topic\\V1\\Rest\\Topic\\TopicCollection',
            'service_name' => 'Topic',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Topic\\V1\\Rest\\Topic\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Topic\\V1\\Rest\\Topic\\Controller' => array(
                0 => 'application/vnd.topic.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Topic\\V1\\Rest\\Topic\\Controller' => array(
                0 => 'application/vnd.topic.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Topic\\V1\\Rest\\Topic\\TopicEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'topic.rest.topic',
                'route_identifier_name' => 'topic_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Topic\\V1\\Rest\\Topic\\TopicCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'topic.rest.topic',
                'route_identifier_name' => 'topic_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Topic\\V1\\Rest\\Topic\\Controller' => array(
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
