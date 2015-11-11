<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Hydrator;

use Zend\Stdlib\Hydrator\HydratorInterface as BaseHydratorInterface;

interface HydratorInterface extends BaseHydratorInterface
{
    public function hydrate(array $data, $object);

    public function extract($object);

    public function getParam($key);

    public function setParam($key, $value = true);

    /**
     * Build an HAL Entity from an object
     *
     * @param mixed $object
     * @return ZF\Hal\Entity
     **/
    public function buildEntity($object);
}
