<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Hydrator\Doctrine\Assets;

use Doctrine\Common\Collections\ArrayCollection;

class OneToManyEntityWithEntities extends OneToManyEntity
{
    /**
     * OneToManyEntityWithEntities constructor.
     *
     * @param ArrayCollection $entities
     */
    public function __construct(ArrayCollection $entities)
    {
        parent::__construct();
        $this->entities = $entities;
    }

    public function getEntities($modifyValue = true)
    {
        return $this->entities;
    }
}
