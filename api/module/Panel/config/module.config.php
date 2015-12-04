<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'Panel\\V1\\Rest\\Panel\\PanelResource' => 'Panel\\V1\\Rest\\Panel\\PanelResourceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'panel.rest.panel' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/panels[/:panel_id]',
                    'defaults' => array(
                        'controller' => 'Panel\\V1\\Rest\\Panel\\Controller',
                    ),
                ),
            ),
        ),
    ),
    'zf-versioning' => array(
        'uri' => array(
            0 => 'panel.rest.panel',
        ),
    ),
    'zf-rest' => array(
        'Panel\\V1\\Rest\\Panel\\Controller' => array(
            'listener' => 'Panel\\V1\\Rest\\Panel\\PanelResource',
            'route_name' => 'panel.rest.panel',
            'route_identifier_name' => 'panel_id',
            'collection_name' => 'panels',
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
            'entity_class' => 'Panel\\V1\\Rest\\Panel\\PanelEntity',
            'collection_class' => 'Panel\\V1\\Rest\\Panel\\PanelCollection',
            'service_name' => 'Panel',
        ),
    ),
    'zf-content-negotiation' => array(
        'controllers' => array(
            'Panel\\V1\\Rest\\Panel\\Controller' => 'HalJson',
        ),
        'accept_whitelist' => array(
            'Panel\\V1\\Rest\\Panel\\Controller' => array(
                0 => 'application/vnd.panel.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ),
        ),
        'content_type_whitelist' => array(
            'Panel\\V1\\Rest\\Panel\\Controller' => array(
                0 => 'application/vnd.panel.v1+json',
                1 => 'application/json',
            ),
        ),
    ),
    'zf-hal' => array(
        'metadata_map' => array(
            'Panel\\V1\\Rest\\Panel\\PanelEntity' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'panel.rest.panel',
                'route_identifier_name' => 'panel_id',
                'hydrator' => 'Zend\\Stdlib\\Hydrator\\ObjectProperty',
            ),
            'Panel\\V1\\Rest\\Panel\\PanelCollection' => array(
                'entity_identifier_name' => 'id',
                'route_name' => 'panel.rest.panel',
                'route_identifier_name' => 'panel_id',
                'is_collection' => true,
            ),
        ),
    ),
    'zf-mvc-auth' => array(
        'authorization' => array(
            'Panel\\V1\\Rest\\Panel\\Controller' => array(
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
