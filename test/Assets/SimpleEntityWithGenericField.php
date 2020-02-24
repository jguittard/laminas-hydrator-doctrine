<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Hydrator\Doctrine\Assets;

class SimpleEntityWithGenericField
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var float
     */
    protected $genericField;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setGenericField($value)
    {
        $this->genericField = $value;

        return $this;
    }

    public function getGenericField()
    {
        return $this->genericField;
    }
}
