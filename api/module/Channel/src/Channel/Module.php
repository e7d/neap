<?php
namespace Channel;

use Channel\Model\Channel;
use Channel\Service\ChannelService;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'ZF\Apigility\Autoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Channel\Service\ChannelService' =>  function($services) {
                    $channelTableGateway = $services->get('Channel\Service\ChannelTableGateway');
                    $table = new ChannelService($channelTableGateway);
                    return $table;
                },
                'Channel\Service\ChannelTableGateway' => function ($services) {
                    $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
                    $resultSet = new ResultSet();
                    $resultSet->setArrayObjectPrototype(new Channel());
                    return new TableGateway('channel', $adapter, null, $resultSet);
                },
            ),
        );
    }
}
