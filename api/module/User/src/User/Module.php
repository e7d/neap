<?php
namespace User;

use User\Model\User;
use User\Service\UserService;
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
                'User\Service\UserService' =>  function($services) {
                    $userTableGateway = $services->get('User\Service\UserTableGateway');
                    $table = new UserService($userTableGateway);
                    return $table;
                },
                'User\Service\UserTableGateway' => function ($services) {
                    $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
                    $resultSet = new ResultSet();
                    $resultSet->setArrayObjectPrototype(new User());
                    return new TableGateway('user', $adapter, null, $resultSet);
                },
            ),
        );
    }
}
