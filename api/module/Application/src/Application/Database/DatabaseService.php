<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database;

use Zend\Db\Adapter\Adapter;

/**
 * Handes database connection
 */
class DatabaseService
{
    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->adapter = new Adapter($config);
    }

    /**
     * @return Adapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }
}
