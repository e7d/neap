<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Database\Mod;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class ModModelTest extends AbstractControllerTestCase
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
        $modModel = $this->serviceManager->get('Application\Database\Mod\ModModel');

        $this->assertInstanceOf('Application\Database\Mod\ModModel', $modModel);
    }

    public function testGetTableGateway()
    {
        $modModel = $this->serviceManager->get('Application\Database\Mod\ModModel');

        $tableGateway = $modModel->getTableGateway();
        $this->assertInstanceOf('Zend\Db\TableGateway\TableGateway', $tableGateway);
    }
}
