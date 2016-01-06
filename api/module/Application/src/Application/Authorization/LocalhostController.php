<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Authorization;

use Zend\Mvc\Controller\AbstractActionController;

class LocalhostController extends AbstractActionController
{
    public function assertLocalConnection()
    {
        if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1') {
            throw new \DomainException('Access');
        }
    }

    public function log($data) {
        if (is_array($data)) {
            $data = json_encode($data, JSON_PRETTY_PRINT);
        }

        file_put_contents('/var/log/nginx/transcode.log', $data . PHP_EOL, FILE_APPEND);
    }
}
