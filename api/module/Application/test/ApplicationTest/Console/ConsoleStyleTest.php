<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Console;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class ConsoleStyleTest extends AbstractControllerTestCase
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
        $consoleStyle = $this->serviceManager->get('Application\Console\ConsoleStyle');

        $this->assertInstanceOf('Application\Console\ConsoleStyle', $consoleStyle);
    }

    public function testBuild()
    {
        $consoleStyle = $this->serviceManager->get('Application\Console\ConsoleStyle');

        // Test red text
        $result = $consoleStyle->build('{red}Red{/} text');
        $this->assertEquals('1b5b303b33316d5265641b5b306d2074657874', bin2hex($result));

        // Test yellow background with bold blue text
        $result = $consoleStyle->build('{bg,yellow}{bold,blue}Blue on Yellow{/} text');
        $this->assertEquals('1b5b34336d1b5b313b33346d426c7565206f6e2059656c6c6f771b5b306d2074657874', bin2hex($result));
    }
}
