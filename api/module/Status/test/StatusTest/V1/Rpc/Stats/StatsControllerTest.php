<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace StatusTest\V1\Rpc\Stats;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class StatsControllerTest extends AbstractHttpControllerTestCase
{
    private $serviceManager;

    public function setUp()
    {
        $this->setApplicationConfig(
            include './config/tests.config.php'
        );
        parent::setUp();

        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    }

    public function testStatsActionIsAccessible()
    {
        $request = $this->getRequest();
        $request->setMethod('GET');

        $headers = $request->getHeaders();
        $headers->addHeaderLine('Accept', 'application/json');

        $this->dispatch('/stats');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('status');
        $this->assertControllerName('Status\V1\Rpc\Stats\Controller');
        $this->assertControllerClass('StatsController');
        $this->assertMatchedRouteName('status.rpc.stats');
    }
}
