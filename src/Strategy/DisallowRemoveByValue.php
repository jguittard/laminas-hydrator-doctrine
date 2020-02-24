<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Hydrator\Doctrine\Strategy;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Inflector\Inflector;
use Laminas\Hydrator\Doctrine\Exception;

use function array_udiff;
use function get_class;
use function method_exists;
use function sprintf;

class DisallowRemoveByValue extends CollectionStrategy
{
    /**
     * @inheritDoc
     */
    public function hydrate($value, ?array $data)
    {
        $adder = 'add' . Inflector::classify($this->collectionName);

        if (! method_exists($this->object, $adder)) {
            throw new Exception\LogicException(
                sprintf(
                    'DisallowRemove strategy for Doctrine hydrator requires %s to
                     be defined in %s entity domain code, but it seems to be missing',
                    $adder,
                    get_class($this->object)
                )
            );
        }

        $collection = $this->getCollectionFromObjectByValue();

        if ($collection instanceof Collection) {
            $collection = $collection->toArray();
        }

        $toAdd = new ArrayCollection(array_udiff($value, $collection, [$this, 'compareObjects']));

        $this->object->$adder($toAdd);

        return $collection;
    }
}
