<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Authorization;

use Application\Authorization\AuthorizationAwareResourceTrait;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class AuthorizationAwareResourceTraitTest extends AbstractControllerTestCase
{
    use AuthorizationAwareResourceTrait;

    protected $identityService;
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

    public function testTraitIsLoaded()
    {
        $this->assertContains('userIsOwner', get_class_methods($this));
    }

    public function testUserIsOwner()
    {
        $this->identityService = $this->serviceManager->get('Application\Authorization\IdentityService');

        // Test without service
        $isOwner = $this->userIsOwner(null);
        $this->assertInstanceOf('ZF\ApiProblem\ApiProblem', $isOwner);
        $this->assertEquals(500, $isOwner->status);
        $this->assertEquals('This resource does not expose a valid service', $isOwner->detail);

        // Test an invalid service
        $this->service = $this->serviceManager->get('Ingest\V1\Service\IngestService');
        $isOwner = $this->userIsOwner(null);
        $this->assertInstanceOf('ZF\ApiProblem\ApiProblem', $isOwner);
        $this->assertEquals(500, $isOwner->status);
        $this->assertEquals('This resource service does not expose an owner validation method', $isOwner->detail);

        // Now use a valid Service
        $this->service = $this->serviceManager->get('Channel\V1\Service\ChannelService');

        // Test without any logged in user
        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $isOwner = $this->userIsOwner($channelId);
        $this->assertInstanceOf('ZF\ApiProblem\ApiProblem', $isOwner);
        $this->assertEquals(401, $isOwner->status);

        // Test an invalid entity
        $channelId = 'e310dfdc-bf2e-4b28-8e37-00f12677cf5b'; // Invalid channel id
        $identity = new \stdClass();
        $identity->user_id = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $this->identityService->setIdentity($identity);
        $isOwner = $this->userIsOwner($channelId);
        $this->assertInstanceOf('ZF\ApiProblem\ApiProblem', $isOwner);
        $this->assertEquals(403, $isOwner->status);

        // Now use a valid entity, and its rightful owner
        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $identity = new \stdClass();
        $identity->user_id = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $this->identityService->setIdentity($identity);
        $isOwner = $this->userIsOwner($channelId);
        $this->assertTrue($isOwner);

        // Test a valid entit with a random id
        $identity = new \stdClass();
        $identity->user_id = '6941f890-aea2-4e18-b9af-b9896f328a56';
        $this->identityService->setIdentity($identity);
        $isOwner = $this->userIsOwner($channelId);
        $this->assertInstanceOf('ZF\ApiProblem\ApiProblem', $isOwner);
    }
}
