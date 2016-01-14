<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ConsoleTest\Controller\Irc;

use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;

class IrcClientTest extends AbstractConsoleControllerTestCase
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

    public function testRegisterActionIsAccessible()
    {
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        // $this->dispatch('--your-arg');
        // $this->assertResponseStatusCode(0);
        //
        // $this->assertModule('application');
        // $this->assertControllerName('application_console');
        // $this->assertControllerClass('ConsoleController');
        // $this->assertMatchedRouteName('myaction');
    }
}
