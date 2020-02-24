<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Hydrator\Doctrine\Assets;

class SimpleIsEntity
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var bool
     */
    protected $done;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setDone($done)
    {
        $this->done = (bool) $done;
    }

    public function isDone()
    {
        return $this->done;
    }
}
