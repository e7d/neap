<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace TeamTest\V1\Service;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class TeamServiceTest extends AbstractControllerTestCase
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
        $teamService = $this->serviceManager->get('Team\V1\Service\TeamService');

        $this->assertInstanceOf('Team\V1\Service\TeamService', $teamService);
    }

    public function testFetchAll()
    {
        $teamService = $this->serviceManager->get('Team\V1\Service\TeamService');

        $teamCollection = $teamService->fetchAll();

        $this->assertInstanceOf('Team\V1\Rest\Team\TeamCollection', $teamCollection);
        $this->assertTrue(0 < $teamCollection->getTotalItemCount());

        $teamEntity = $teamCollection->getCurrentItems()->current();

        $this->assertInstanceOf('ZF\Hal\Entity', $teamEntity);
    }

    public function testFetch()
    {
        $teamService = $this->serviceManager->get('Team\V1\Service\TeamService');

        $teamId = '9880b00c-814a-423e-ab39-5fa20039414a'; // Lonely Assailant team id
        $teamEntity = $teamService->fetch($teamId);

        $this->assertInstanceOf('ZF\Hal\Entity', $teamEntity);
        $this->assertEquals($teamId, $teamEntity->entity->team_id);
    }

    public function testFetchInvalidTeam()
    {
        $teamService = $this->serviceManager->get('Team\V1\Service\TeamService');

        $teamId = '00000000-0000-0000-0000-000000000000'; // Invalid team id
        $teamEntity = $teamService->fetch($teamId);

        $this->assertNull($teamEntity);
    }

    public function testFetchUsers()
    {
        $teamService = $this->serviceManager->get('Team\V1\Service\TeamService');

        $teamId = '9880b00c-814a-423e-ab39-5fa20039414a'; // Lonely Assailant team id

        $followerCollection = $teamService->fetchUsers(array(
            'team_id' => $teamId
        ));

        $this->assertInstanceOf('Team\V1\Rest\User\UserCollection', $followerCollection);
    }
}
