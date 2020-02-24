<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Hydrator\Doctrine\Filter;

use Laminas\Hydrator\Filter\FilterInterface;

use function in_array;
use function is_array;

class PropertyName implements FilterInterface
{
    /**
     * The properties to exclude.
     *
     * @var array
     */
    protected $properties = [];

    /**
     * Either an exclude or an include.
     *
     * @var bool
     */
    protected $exclude;

    /**
     * PropertyName constructor.
     *
     * @param array|string $properties
     * @param bool $exclude
     */
    public function __construct($properties, bool $exclude)
    {
        $this->exclude    = $exclude;
        $this->properties = is_array($properties)
            ? $properties
            : [$properties];
    }

    /**
     * @inheritDoc
     */
    public function filter(string $property): bool
    {
        return in_array($property, $this->properties)
            ? ! $this->exclude
            : $this->exclude;
    }
}
