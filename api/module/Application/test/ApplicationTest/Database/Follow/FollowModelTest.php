<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Database\Follow;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class FollowModelTest extends AbstractControllerTestCase
{
    private $serviceManager;

    public function setUp()
    {
        $this->setApplicationConfig(
            include './config/tests.config.php'
        );
        parent::setUp();
        $this->serviceManager = $this->getApplicationServiceLocator();
        $this->serviceManager->setAllowOverride(true);
    }

    public function testClassType()
    {
        $followModel = $this->serviceManager->get('Application\Database\Follow\FollowModel');

        $this->assertInstanceOf('Application\Database\Follow\FollowModel', $followModel);
    }

    public function testGetTableGateway()
    {
        $followModel = $this->serviceManager->get('Application\Database\Follow\FollowModel');

        $tableGateway = $followModel->getTableGateway();
        $this->assertInstanceOf('Zend\Db\TableGateway\TableGateway', $tableGateway);
    }

    public function testFetchByUserId()
    {
        $followModel = $this->serviceManager->get('Application\Database\Follow\FollowModel');

        $userId = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $follows = $followModel->fetchByUser($userId);
        $this->assertInstanceOf('Zend\Db\ResultSet\ResultSet', $follows);
        $this->assertEquals(70, $follows->count());

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $follows = $followModel->fetchByUser($userId);
        $this->assertInstanceOf('Zend\Db\ResultSet\ResultSet', $follows);
        $this->assertEquals(0, $follows->count());
    }
}
