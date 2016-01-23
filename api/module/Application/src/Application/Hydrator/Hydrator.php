<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator;

use ZF\Hal\Link\Link;

abstract class Hydrator implements HydratorInterface
{
    protected $link;
    private $params = array();

    public function __construct()
    {
        $this->link = new Link('hydrator');
    }

    public function hydrate(array $data, $object)
    {
        $object->exchangeArray($data);
        $objectEntity = $this->buildEntity($object);
        return $objectEntity;
    }

    public function extract($object)
    {
        return get_object_vars($object);
    }

    public function getParam($key)
    {
        if (!array_key_exists($key, $this->params)) {
            return null;
        }

        return $this->params[$key];
    }

    public function setParam($key, $value = true)
    {
        $this->params[$key] = $value;
    }
}
