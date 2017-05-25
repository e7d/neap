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

namespace Application\Hydrator;

use Zend\Stdlib\Hydrator\ObjectProperty;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;
use Zend\Stdlib\Hydrator\AbstractHydrator;

/**
 * Handles hydration of database objects
 */
abstract class Hydrator extends AbstractHydrator
{
    /** @var Entity */
    protected $entity;

    /** @var Link */
    protected $link;

    /** @var object */
    protected $object;

    /** @var array */
    private $params = array();

    /**
     */
    public function __construct()
    {
        $this->link = new Link('hydrator');
    }

    /**
     * {@inheritDoc}
     *
     * Builds an entity public properties from an array of data
     *
     * @param array  $data   The data values
     * @param object $object The base data object to feed
     *
     * @return Entity
     */
    public function hydrate(array $data, $object)
    {
        $object->exchangeArray($data);
        return $this->buildEntity($object);
    }

    /**
     * {@inheritDoc}
     *
     * Extracts the object
     *
     * @param object $object The object to extract
     *
     * @return object
     */
    public function extract($object)
    {
        return $object;
    }

    /**
     * Extracts the object as an array
     *
     * @param object $object The object to extract
     *
     * @return array
     */
    public function extractArray($object)
    {
        return get_object_vars($object);
    }

    /**
     * Builds an entity from an object
     *
     * @return Entity
     */
    public function buildEntity($object)
    {
        return new Entity($object);
    }

    /**
     * @param string $key
     *
     * @return mixed|null
     */
    public function getParam(string $key)
    {
        if (!$this->hasParam($key)) {
            return null;
        }

        return $this->params[$key];
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasParam(string $key)
    {
        return array_key_exists($key, $this->params);
    }

    /**
     * @param string|array $key
     * @param mixed|null   $value
     *
     * @return self
     */
    public function setParam($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $key => $value) {
                $this->setParam($key, $value);
            }
            return $this;
        }

        $this->params[$key] = $value;

        return $this;
    }

    /**
     * Embeds an object inside another object
     *
     * @param string $param         A unicity parameter flag, preventing to embed the same object multiple times
     * @param object $embed         The object to embed
     * @param string $linkRouteName The link route to the embedded object
     *
     * @return self
     */
    public function addEmbed(string $param, $embed, string $linkRouteName = null)
    {
        if (!is_null($param) && !$this->hasParam($param)) {
            return $this;
        }
        if (is_null($embed)) {
            return $this;
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

        return $this;
    }

    /**
     * Adds a "self" link to an object
     *
     * @return self
     */
    public function addSelfLink()
    {
        $this->addLink(null, $this->object, 'self');

        return $this;
    }

    /**
     * Embeds a object as link inside another object
     *
     * @param string|null $param         A unicity parameter flag, preventing to embed the same object multiple times
     * @param object      $embed         The object to embed as link
     * @param string|null $linkRel       The link "rel" attribute
     * @param string|null $linkRouteName The link route to the embedded object
     *
     * @return self
     */
    public function addLink($param, $embed, string $linkRel = null, string $linkRouteName = null)
    {
        if (!is_null($param) && !$this->hasParam($param)) {
            return $this;
        }
        if (is_null($embed)) {
            return $this;
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

        return $this;
    }

    /**
     * Extracts the properties composing an object
     *
     * @param object $object
     *
     * @return array
     */
    private function extractMeta($object)
    {
        $objectReflection = new \ReflectionClass($object);
        $className = strtolower($objectReflection->getShortName());
        $primaryKey = $objectReflection->getProperties()[0]->name;

        return array($className, $primaryKey);
    }
}
