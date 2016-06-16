<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace EmojiTest\V1\Rest\Emoji;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class EmojiResourceTest extends AbstractControllerTestCase
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
        $emojiResource = $this->serviceManager->get('Emoji\V1\Rest\Emoji\EmojiResource');

        $this->assertInstanceOf('Emoji\V1\Rest\Emoji\EmojiResource', $emojiResource);
    }
}
