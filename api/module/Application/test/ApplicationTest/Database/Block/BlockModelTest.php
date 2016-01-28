<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace ApplicationTest\Database\Block;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class BlockModelTest extends AbstractControllerTestCase
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
        $blockModel = $this->serviceManager->get('Application\Database\Block\BlockModel');

        $this->assertInstanceOf('Application\Database\Block\BlockModel', $blockModel);
    }

    public function testGetTableGateway()
    {
        $blockModel = $this->serviceManager->get('Application\Database\Block\BlockModel');

        $tableGateway = $blockModel->getTableGateway();
        $this->assertInstanceOf('Zend\Db\TableGateway\TableGateway', $tableGateway);
    }

    public function testGetSqlSelect()
    {
        $blockModel = $this->serviceManager->get('Application\Database\Block\BlockModel');
        $select = $blockModel->getSqlSelect();

        $this->assertInstanceOf('Zend\Db\Sql\Select', $select);
        $this->assertEquals('SELECT "block".* FROM "block"', $select->getSqlString());
    }
}
