<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database;

class DatabaseService
{
    private $adapter;

    public function __construct($config)
    {
        var_dump($config); die;
        $this->adapter = new \Zend\Db\Adapter\Adapter($config);
    }

    public function getAdapter()
    {
        return $this->adapter;
    }
}
