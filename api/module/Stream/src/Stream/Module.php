<?php
namespace Stream;

use Stream\Model\Stream;
use Stream\Model\StreamOwner;
use Stream\Service\StreamService;
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
                'Stream\Service\StreamService' =>  function($services) {
                    $streamTableGateway = $services->get('Stream\Service\StreamTableGateway');
                    $table = new StreamService($streamTableGateway);
                    return $table;
                },
                'Stream\Service\StreamTableGateway' => function ($services) {
                    $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
                    $resultSet = new ResultSet();
                    $resultSet->setArrayObjectPrototype(new Stream());
                    return new TableGateway('stream', $adapter, null, $resultSet);
                },
            ),
        );
    }
}
