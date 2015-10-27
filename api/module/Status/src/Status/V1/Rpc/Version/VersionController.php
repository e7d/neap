<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Status\V1\Rpc\Version;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;

class VersionController extends AbstractActionController
{
    public function versionAction()
    {
        return new ViewModel(
            array(
                'version' => '0.1'
            )
        );
    }
}
