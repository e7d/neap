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
