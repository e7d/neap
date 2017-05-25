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

namespace ApplicationTest\Converter;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class DateConverterTest extends AbstractControllerTestCase
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
        $dateConverter = $this->serviceManager->get('Application\Converter\DateConverter');

        $this->assertInstanceOf('Application\Converter\DateConverter', $dateConverter);
    }

    public function testFromTimestamp()
    {
        $dateConverter = $this->serviceManager->get('Application\Converter\DateConverter');

        // test result format
        $result = $dateConverter->fromTimestamp();
        $this->assertEquals(1, preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}.[0-9]{6}\+[0-9]{4}/', $result));

        // test exact value
        $microtime = 1452977584.0254;
        $result = $dateConverter->fromTimestamp($microtime);
        $this->assertEquals('2016-01-16 20:53:04.025400+0000', $result);
    }
}
