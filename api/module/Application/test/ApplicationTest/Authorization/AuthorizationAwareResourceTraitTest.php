<?php
/**
 * Neap (http://neap.io/)
 *
 * @package   Neap
 * @author    Michaël "e7d" Ferrand <michael@e7d.io>
 * @copyright 2017 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 * @link      https://github.com/e7d/neap
 *
 * PHP version 7.1
 */

namespace ApplicationTest\Authorization;

use Application\Database\User\User;
use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class AuthorizationAwareResourceTraitTest extends AbstractControllerTestCase
{
    private $serviceManager;
    private $resource;

    public function setUp()
    {
        $this->setApplicationConfig(
            include './config/tests.config.php'
        );
        parent::setUp();
        $this->serviceManager = $this->getApplicationServiceLocator();
        $this->serviceManager->setAllowOverride(true);

        // prepare dummy resource
        $this->resource = $this->getMockForAbstractClass('Application\Rest\AbstractResourceListener');
        $this->setProtectedProperty(
            $this->resource,
            'identityService',
            $this->serviceManager->get('Application\Authorization\IdentityService')
        );
    }

    /**
     * Sets a protected property on a given object via reflection
     *
     * @param mixed $object instance in which protected value is being modified
     * @param string $property property on instance being modified
     * @param mixed $value new value of the property being modified
     *
     * @return void
     */
    private function setProtectedProperty($object, $property, $value)
    {
        $reflection = new \ReflectionClass($object);
        $reflection_property = $reflection->getProperty($property);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, $value);
    }

    public function testTraitIsLoaded()
    {
        $this->assertContains('userIsOwner', get_class_methods($this->resource));
    }

    public function testUserIsOwner()
    {
        // Test without service
        $isOwner = $this->resource->userIsOwner('');
        $this->assertInstanceOf('ZF\ApiProblem\ApiProblem', $isOwner);
        $this->assertEquals(500, $isOwner->status);
        $this->assertEquals('This resource does not expose a valid service', $isOwner->detail);

        // Test an invalid service
        $this->setProtectedProperty(
            $this->resource,
            'service',
            $this->serviceManager->get('Ingest\V1\Service\IngestService')
        );
        $isOwner = $this->resource->userIsOwner('');
        $this->assertInstanceOf('ZF\ApiProblem\ApiProblem', $isOwner);
        $this->assertEquals(500, $isOwner->status);
        $this->assertEquals('This resource service does not expose an owner validation method', $isOwner->detail);

        // Now use a valid Service
        $this->setProtectedProperty(
            $this->resource,
            'service',
            $this->serviceManager->get('Channel\V1\Service\ChannelService')
        );

        // Test without any logged in user
        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $isOwner = $this->resource->userIsOwner($channelId);
        $this->assertInstanceOf('ZF\ApiProblem\ApiProblem', $isOwner);
        $this->assertEquals(401, $isOwner->status);

        // Test an invalid entity
        $channelId = 'e310dfdc-bf2e-4b28-8e37-00f12677cf5b'; // Invalid channel id
        $identity = new User();
        $identity->user_id = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $this->resource->getIdentityService()->setIdentity($identity);
        $isOwner = $this->resource->userIsOwner($channelId);
        $this->assertInstanceOf('ZF\ApiProblem\ApiProblem', $isOwner);
        $this->assertEquals(403, $isOwner->status);

        // Now use a valid entity, and its rightful owner
        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $identity = new User();
        $identity->user_id = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $this->resource->getIdentityService()->setIdentity($identity);
        $isOwner = $this->resource->userIsOwner($channelId);
        $this->assertTrue($isOwner);

        // Test a valid entity with a random id
        $identity = new User();
        $identity->user_id = '6941f890-aea2-4e18-b9af-b9896f328a56';
        $this->resource->getIdentityService()->setIdentity($identity);
        $isOwner = $this->resource->userIsOwner($channelId);
        $this->assertInstanceOf('ZF\ApiProblem\ApiProblem', $isOwner);
    }
}
