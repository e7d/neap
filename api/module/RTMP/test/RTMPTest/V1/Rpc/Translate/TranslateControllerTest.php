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

namespace RTMPTest\V1\Rpc\Translate;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class TranslateControllerTest extends AbstractHttpControllerTestCase
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

    public function testTranslateActionIsAccessible()
    {
        $request = $this->getRequest();
        $request->setMethod('GET');

        $headers = $request->getHeaders();
        $headers->addHeaderLine('Accept', 'application/json');

        $this->dispatch('/rtmp/translate?stream_key=live_2cf2c9e2_e2087e7fffee8c2eee095c6d');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('rtmp');
        $this->assertControllerName('RTMP\V1\Rpc\Translate\Controller');
        $this->assertControllerClass('TranslateController');
        $this->assertMatchedRouteName('rtmp.rpc.translate');
    }
}
