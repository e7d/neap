<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

return array(
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'Application\Authorization\AuthorizationListener' => 'Application\Authorization\AuthorizationListenerFactory',
            'Application\Database\DatabaseService' => 'Application\Database\DatabaseServiceFactory',
            'Application\Database\Block\BlockModel' => 'Application\Database\Block\BlockModelFactory',
            'Application\Database\Block\BlockTableGateway' => 'Application\Database\Block\BlockTableGatewayFactory',
            'Application\Database\Channel\ChannelModel' => 'Application\Database\Channel\ChannelModelFactory',
            'Application\Database\Channel\ChannelTableGateway' => 'Application\Database\Channel\ChannelTableGatewayFactory',
            'Application\Database\Chat\ChatModel' => 'Application\Database\Chat\ChatModelFactory',
            'Application\Database\Chat\ChatTableGateway' => 'Application\Database\Chat\ChatTableGatewayFactory',
            'Application\Database\Follow\FollowModel' => 'Application\Database\Follow\FollowModelFactory',
            'Application\Database\Follow\FollowTableGateway' => 'Application\Database\Follow\FollowTableGatewayFactory',
            'Application\Database\Ingest\IngestModel' => 'Application\Database\Ingest\IngestModelFactory',
            'Application\Database\Ingest\IngestTableGateway' => 'Application\Database\Ingest\IngestTableGatewayFactory',
            'Application\Database\Mod\ModModel' => 'Application\Database\Mod\ModModelFactory',
            'Application\Database\Mod\ModTableGateway' => 'Application\Database\Mod\ModTableGatewayFactory',
            'Application\Database\Outage\OutageModel' => 'Application\Database\Outage\OutageModelFactory',
            'Application\Database\Outage\OutageTableGateway' => 'Application\Database\Outage\OutageTableGatewayFactory',
            'Application\Database\Panel\PanelModel' => 'Application\Database\Panel\PanelModelFactory',
            'Application\Database\Panel\PanelTableGateway' => 'Application\Database\Panel\PanelTableGatewayFactory',
            'Application\Database\Stream\StreamModel' => 'Application\Database\Stream\StreamModelFactory',
            'Application\Database\Stream\StreamTableGateway' => 'Application\Database\Stream\StreamTableGatewayFactory',
            'Application\Database\Team\TeamModel' => 'Application\Database\Team\TeamModelFactory',
            'Application\Database\Team\TeamTableGateway' => 'Application\Database\Team\TeamTableGatewayFactory',
            'Application\Database\Topic\TopicModel' => 'Application\Database\Topic\TopicModelFactory',
            'Application\Database\Topic\TopicTableGateway' => 'Application\Database\Topic\TopicTableGatewayFactory',
            'Application\Database\User\UserModel' => 'Application\Database\User\UserModelFactory',
            'Application\Database\User\UserTableGateway' => 'Application\Database\User\UserTableGatewayFactory',
            'Application\Database\Video\VideoModel' => 'Application\Database\Video\VideoModelFactory',
            'Application\Database\Video\VideoTableGateway' => 'Application\Database\Video\VideoTableGatewayFactory',
            'Application\Hydrator\Block\BlockHydrator' => 'Application\Hydrator\Block\BlockHydratorFactory',
            'Application\Hydrator\Channel\ChannelHydrator' => 'Application\Hydrator\Channel\ChannelHydratorFactory',
            'Application\Hydrator\Chat\ChatHydrator' => 'Application\Hydrator\Chat\ChatHydratorFactory',
            'Application\Hydrator\Follow\FollowHydrator' => 'Application\Hydrator\Follow\FollowHydratorFactory',
            'Application\Hydrator\Ingest\IngestHydrator' => 'Application\Hydrator\Ingest\IngestHydratorFactory',
            'Application\Hydrator\Mod\ModHydrator' => 'Application\Hydrator\Mod\ModHydratorFactory',
            'Application\Hydrator\Outage\OutageHydrator' => 'Application\Hydrator\Outage\OutageHydratorFactory',
            'Application\Hydrator\Panel\PanelHydrator' => 'Application\Hydrator\Panel\PanelHydratorFactory',
            'Application\Hydrator\Stream\StreamHydrator' => 'Application\Hydrator\Stream\StreamHydratorFactory',
            'Application\Hydrator\Team\TeamHydrator' => 'Application\Hydrator\Team\TeamHydratorFactory',
            'Application\Hydrator\Topic\TopicHydrator' => 'Application\Hydrator\Topic\TopicHydratorFactory',
            'Application\Hydrator\User\UserHydrator' => 'Application\Hydrator\User\UserHydratorFactory',
            'Application\Hydrator\Video\VideoHydrator' => 'Application\Hydrator\Video\VideoHydratorFactory',
        ),
        'invokables' => array(
            'Application\Authorization\IdentityService' => 'Application\Authorization\IdentityService',
            'Application\Validator\UuidV4' => 'Application\Validator\UuidV4',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => false,
        'display_exceptions'       => false,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/500',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/500'               => __DIR__ . '/../view/error/500.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
