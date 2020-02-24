<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Hydrator\Doctrine\Assets;

class NamingStrategyEntity
{
    /**
     * @var null|string
     */
    protected $camelCase;

    /**
     * NamingStrategyEntity constructor.
     *
     * @param string|null $camelCase
     */
    public function __construct(string $camelCase = null)
    {
        $this->camelCase = $camelCase;
    }

    /**
     * @return string|null
     */
    public function getCamelCase(): ?string
    {
        return $this->camelCase;
    }

    /**
     * @param string|null $camelCase
     * @return NamingStrategyEntity
     */
    public function setCamelCase(?string $camelCase): NamingStrategyEntity
    {
        $this->camelCase = $camelCase;
        return $this;
    }
}
