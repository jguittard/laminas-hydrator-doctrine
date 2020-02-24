<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Hydrator\Doctrine\Assets;

use Laminas\Hydrator\Strategy\StrategyInterface;

class SimpleStrategy implements StrategyInterface
{
    /**
     * @inheritDoc
     */
    public function extract($value, ?object $object = null)
    {
        return 'modified while extracting';
    }

    /**
     * @inheritDoc
     */
    public function hydrate($value, ?array $data)
    {
        return 'modified while hydrating';
    }
}
