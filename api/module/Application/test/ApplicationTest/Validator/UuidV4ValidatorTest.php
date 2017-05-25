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

namespace ApplicationTest\Validator;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class UuidV4ValidatorTest extends AbstractControllerTestCase
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
        $uuidV4Validator = $this->serviceManager->get('Application\Validator\UuidV4Validator');

        $this->assertInstanceOf('Application\Validator\UuidV4Validator', $uuidV4Validator);
    }

    public function testIsValid()
    {
        $uuidV4Validator = $this->serviceManager->get('Application\Validator\UuidV4Validator');

        $validUuidV4 = '95d36156-24fc-4b9f-9490-4adf4e48d08c';
        $malformedUuid = 'c671d543-9c16-4dfa-90';
        $invalidUuidV4 = '61fdf5e8-474e-7140-9470-08af54aea5af';

        $this->assertTrue($uuidV4Validator->isValid($validUuidV4));
        $this->assertFalse($uuidV4Validator->isValid($malformedUuid));
        $this->assertFalse($uuidV4Validator->isValid($invalidUuidV4));
    }
}
