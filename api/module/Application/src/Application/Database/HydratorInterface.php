<?php
namespace Application\Database;

use Zend\Stdlib\Hydrator\HydratorInterface as BaseHydratorInterface;

interface HydratorInterface extends BaseHydratorInterface
{
    public function hydrate(array $data, $object);

    public function extract($object);

    public function getParam($key);

    public function setParam($key, $value = true);

    public function buildEntity($object);
}
