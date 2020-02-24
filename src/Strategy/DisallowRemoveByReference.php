<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Hydrator\Doctrine\Strategy;

use function array_udiff;

class DisallowRemoveByReference extends CollectionStrategy
{
    /**
     * @inheritDoc
     */
    public function hydrate($value, ?array $data)
    {
        $collection = $this->getCollectionFromObjectByReference();
        $collectionArray = $collection->toArray();

        $toAdd = array_udiff($value, $collectionArray, [$this, 'compareObjects']);

        foreach ($toAdd as $element) {
            $collection->add($element);
        }

        return $collection;
    }
}
