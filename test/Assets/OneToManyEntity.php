<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Hydrator\Doctrine\Assets;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class OneToManyEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Collection
     */
    protected $entities;

    /**
     * OneToManyEntity constructor.
     */
    public function __construct()
    {
        $this->entities = new ArrayCollection();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function addEntities(Collection $entities, $modifyValue = true)
    {
        foreach ($entities as $entity) {
            // Modify the value to illustrate the difference between by value and by reference
            if ($modifyValue) {
                $entity->setField('Modified from addEntities adder', false);
            }

            $this->entities->add($entity);
        }
    }

    public function removeEntities(Collection $entities)
    {
        foreach ($entities as $entity) {
            $this->entities->removeElement($entity);
        }
    }

    public function getEntities($modifyValue = true)
    {
        // Modify the value to illustrate the difference between by value and by reference
        if ($modifyValue) {
            foreach ($this->entities as $entity) {
                $entity->setField('Modified from getEntities getter', false);
            }
        }

        return $this->entities;
    }
}
