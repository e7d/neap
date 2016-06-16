<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator;

use ZF\Hal\Entity;
use ZF\Hal\Link\Link;
use Zend\Stdlib\Hydrator\AbstractHydrator;

abstract class Hydrator extends AbstractHydrator
{
    protected $entity;
    protected $link;
    protected $object;
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
        return $object;
    }

    public function extractArray($object)
    {
        return get_object_vars($object);
    }

    public function buildEntity($object)
    {
        $entity = new Entity($object);
        return $entity;
    }

    public function getParam($key)
    {
        if (!$this->hasParam($key)) {
            return null;
        }

        return $this->params[$key];
    }

    public function hasParam($key)
    {
        return array_key_exists($key, $this->params);
    }

    public function setParam($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $key => $value) {
                $this->setParam($key, $value);
            }
            return;
        }

        $this->params[$key] = $value;
    }

    public function addEmbed($param, $embed, $linkRouteName = null)
    {
        if (!is_null($param) && !$this->hasParam($param)) {
            return;
        }
        if (is_null($embed)) {
            return;
        }

        list($embedClassName, $embedPrimaryKey) = $this->extractMeta($embed);

        if (is_null($linkRouteName)) {
            $linkRouteName = $embedClassName.'.rest.'.$embedClassName;
        }
        $linkSpec = array(
            'rel' => 'self',
            'route' => array(
                'name' => $linkRouteName,
                'params' => array(
                    $embedPrimaryKey => $embed->{$embedPrimaryKey},
                ),
            ),
        );

        $entity = new Entity($embed, $embed->{$embedPrimaryKey});

        $entity->getLinks()->add($this->link->factory($linkSpec));
        $this->object->{$embedClassName} = $entity;
    }

    public function addSelfLink()
    {
        $this->addLink(null, $this->object, 'self');
    }

    public function addLink($param, $embed, $linkRel = null, $linkRouteName = null)
    {
        if (!is_null($param) && !$this->hasParam($param)) {
            return;
        }
        if (is_null($embed)) {
            return;
        }

        list($embedClassName, $embedPrimaryKey) = $this->extractMeta($embed);

        if (is_null($linkRel)) {
            $linkRel = $embedClassName;
        }
        if (is_null($linkRouteName)) {
            $linkRouteName = $embedClassName.'.rest.'.$embedClassName;
        }
        $this->entity->getLinks()->add($this->link->factory(array(
            'rel' => $linkRel,
            'route' => array(
                'name' => $linkRouteName,
                'params' => array(
                    $embedPrimaryKey => $embed->{$embedPrimaryKey},
                ),
            ),
        )));
    }

    private function extractMeta($object)
    {
        $objectReflection = new \ReflectionClass($object);
        $className = strtolower($objectReflection->getShortName());
        $primaryKey = $objectReflection->getProperties()[0]->name;

        return array($className, $primaryKey);
    }
}
