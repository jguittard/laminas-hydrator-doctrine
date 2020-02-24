<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Hydrator\Doctrine\Assets;

class SimpleEntityWithIsBoolean
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var bool
     */
    protected $isActive;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = (bool) $isActive;
    }

    public function isActive()
    {
        return $this->isActive;
    }

    public function getIsActive()
    {
        return $this->isActive();
    }
}
