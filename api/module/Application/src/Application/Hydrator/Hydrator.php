<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Hydrator;

abstract class Hydrator implements HydratorInterface
{
    private $params = array();

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
