<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ChannelTest\V1\Rest\Channel;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class ChannelResourceTest extends AbstractControllerTestCase
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
        $channelResource = $this->serviceManager->get('Channel\V1\Rest\Channel\ChannelResource');

        $this->assertInstanceOf('Channel\V1\Rest\Channel\ChannelResource', $channelResource);
    }

    public function testFetch()
    {
        $channelResource = $this->serviceManager->get('Channel\V1\Rest\Channel\ChannelResource');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $channelEntity = $channelResource->fetch($channelId);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
        $this->assertEquals($channelId, $channelEntity->entity->channel_id);
    }

    public function testFetchAll()
    {
        $channelResource = $this->serviceManager->get('Channel\V1\Rest\Channel\ChannelResource');

        $channelCollection = $channelResource->fetchAll();

        $this->assertInstanceOf('Channel\V1\Rest\Channel\ChannelCollection', $channelCollection);
        $this->assertTrue(0 < $channelCollection->getTotalItemCount());

        $channelEntity = $channelCollection->getCurrentItems()->current();

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
    }

    public function testUpdate()
    {
        $this->identityService = $this->serviceManager->get('Application\Authorization\IdentityService');
        $identity = new \stdClass();
        $identity->user_id = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $this->identityService->setIdentity($identity);

        $channelResource = $this->serviceManager->get('Channel\V1\Rest\Channel\ChannelResource');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $data = array(
            'topic' => 'Test'
        );
        $channelEntity = $channelResource->update($channelId, $data);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
        $this->assertEquals($channelId, $channelEntity->entity->channel_id);
        $this->assertEquals($data['topic'], $channelEntity->entity->topic);
    }

    public function testUpdateWithInvalidUser()
    {
        $this->identityService = $this->serviceManager->get('Application\Authorization\IdentityService');
        $identity = new \stdClass();
        $identity->user_id = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $this->identityService->setIdentity($identity);

        $channelResource = $this->serviceManager->get('Channel\V1\Rest\Channel\ChannelResource');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $data = array(
            'topic' => 'Test'
        );
        $response = $channelResource->update($channelId, $data);

        $this->assertInstanceOf('ZF\ApiProblem\ApiProblem', $response);
        $this->assertEquals('The entity is not your property', $response->detail);
    }

    public function testPatch()
    {
        $this->identityService = $this->serviceManager->get('Application\Authorization\IdentityService');
        $identity = new \stdClass();
        $identity->user_id = 'd9ddc511-fd9b-47a4-a85c-8d5df8fb68b2'; // Jax user id
        $this->identityService->setIdentity($identity);

        $channelResource = $this->serviceManager->get('Channel\V1\Rest\Channel\ChannelResource');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $data = array(
            'topic' => 'Test'
        );
        $channelEntity = $channelResource->patch($channelId, $data);

        $this->assertInstanceOf('ZF\Hal\Entity', $channelEntity);
        $this->assertEquals($channelId, $channelEntity->entity->channel_id);
        $this->assertEquals($data['topic'], $channelEntity->entity->topic);
    }

    public function testPatchWithInvalidUser()
    {
        $this->identityService = $this->serviceManager->get('Application\Authorization\IdentityService');
        $identity = new \stdClass();
        $identity->user_id = '00000000-0000-0000-0000-000000000000'; // Invalid user id
        $this->identityService->setIdentity($identity);

        $channelResource = $this->serviceManager->get('Channel\V1\Rest\Channel\ChannelResource');

        $channelId = '23a057b7-a5b2-48da-ae73-6fd130e8c55e'; // Jax channel id
        $data = array(
            'topic' => 'Test'
        );
        $response = $channelResource->patch($channelId, $data);

        $this->assertInstanceOf('ZF\ApiProblem\ApiProblem', $response);
        $this->assertEquals('The entity is not your property', $response->detail);
    }
}
