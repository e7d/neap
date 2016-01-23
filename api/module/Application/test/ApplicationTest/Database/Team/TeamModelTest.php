<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Database\Team;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class TeamModelTest extends AbstractControllerTestCase
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
        $teamModel = $this->serviceManager->get('Application\Database\Team\TeamModel');

        $this->assertInstanceOf('Application\Database\Team\TeamModel', $teamModel);
    }

    public function testGetTableGateway()
    {
        $teamModel = $this->serviceManager->get('Application\Database\Team\TeamModel');

        $tableGateway = $teamModel->getTableGateway();
        $this->assertInstanceOf('Zend\Db\TableGateway\TableGateway', $tableGateway);
    }

    public function testFetch()
    {
        $teamModel = $this->serviceManager->get('Application\Database\Team\TeamModel');

        $teamId = '9880b00c-814a-423e-ab39-5fa20039414a'; // Lonely Assailant team id
        $team = $teamModel->fetch($teamId);
        $this->assertInstanceOf('Application\Database\Team\Team', $team);
        $this->assertEquals($teamId, $team->team_id);

        $teamId = '00000000-0000-0000-0000-000000000000'; // Invalid team id
        $team = $teamModel->fetch($teamId);
        $this->assertNull($team);
    }

    public function testFetchByUser()
    {
        $teamModel = $this->serviceManager->get('Application\Database\Team\TeamModel');

        $userId = 'bdda6afe-3e48-41a8-9131-e12ac1bf9dd0'; // Kellan user id
        $teams = $teamModel->fetchByUser($userId);
        $this->assertInstanceOf('Zend\Db\ResultSet\ResultSet', $teams);
        $this->assertEquals(5, $teams->count());

        $userId = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $teams = $teamModel->fetchByUser($userId);
        $this->assertInstanceOf('Zend\Db\ResultSet\ResultSet', $teams);
        $this->assertEquals(0, $teams->count());
    }
}
