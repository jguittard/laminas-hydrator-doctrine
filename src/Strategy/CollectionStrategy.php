<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Hydrator\Doctrine\Strategy;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Inflector\Inflector;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Laminas\Hydrator\Doctrine\Exception;
use Laminas\Hydrator\Strategy\StrategyInterface;

abstract class CollectionStrategy implements StrategyInterface
{
    /**
     * @var string
     */
    protected $collectionName;

    /**
     * @var ClassMetadata
     */
    protected $metadata;

    /**
     * @var object
     */
    protected $object;

    /**
     * Set the name of the collection
     *
     * @param  string $collectionName
     * @return CollectionStrategy
     */
    public function setCollectionName(string $collectionName): CollectionStrategy
    {
        $this->collectionName = $collectionName;
        return $this;
    }

    /**
     * Get the name of the collection
     *
     * @return string
     */
    public function getCollectionName()
    {
        return $this->collectionName;
    }

    /**
     * Set the class metadata
     *
     * @param  ClassMetadata $classMetadata
     * @return CollectionStrategy
     */
    public function setClassMetadata(ClassMetadata $classMetadata): CollectionStrategy
    {
        $this->metadata = $classMetadata;
        return $this;
    }

    /**
     * Get the class metadata
     *
     * @return ClassMetadata
     */
    public function getClassMetadata(): ClassMetadata
    {
        return $this->metadata;
    }

    /**
     * Set the object
     *
     * @param  object $object
     * @return CollectionStrategy
     */
    public function setObject(object $object): CollectionStrategy
    {
        $this->object = $object;
        return $this;
    }

    /**
     * Get the object
     *
     * @return object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @inheritDoc
     */
    public function extract($value, ?object $object = null)
    {
        return $value;
    }

    /**
     * Return the collection by value (using the public API)
     *
     * @throws Exception\InvalidArgumentException
     * @return Collection
     */
    protected function getCollectionFromObjectByValue()
    {
        $object = $this->getObject();
        $getter = 'get' . Inflector::classify($this->getCollectionName());

        if (! method_exists($object, $getter)) {
            throw new Exception\LogicException(
                sprintf(
                    'The getter %s to access collection %s in object %s does not exist',
                    $getter,
                    $this->getCollectionName(),
                    get_class($object)
                )
            );
        }

        return $object->$getter();
    }

    /**
     * Return the collection by reference (not using the public API)
     *
     * @return Collection
     */
    protected function getCollectionFromObjectByReference()
    {
        $object = $this->getObject();
        $refl = $this->getClassMetadata()->getReflectionClass();
        $reflProperty = $refl->getProperty($this->getCollectionName());

        $reflProperty->setAccessible(true);

        return $reflProperty->getValue($object);
    }


    /**
     * This method is used internally by array_udiff to check if two objects are equal, according to their
     * SPL hash. This is needed because the native array_diff only compare strings
     *
     * @param object $a
     * @param object $b
     * @return int
     */
    protected function compareObjects($a, $b)
    {
        return strcmp(spl_object_hash($a), spl_object_hash($b));
    }
}
