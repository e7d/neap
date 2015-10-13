<?php
/**
 * @license   xxx
 * @copyright xxx
 */

namespace Application\Database;

class DatabaseService
{
    private $adapter;

    public function __construct($config)
    {
        $this->adapter = new \Zend\Db\Adapter\Adapter($config);
    }

    public function getAdapter()
    {
        return $this->adapter;
    }
}
