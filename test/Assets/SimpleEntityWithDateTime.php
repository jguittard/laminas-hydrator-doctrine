<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Hydrator\Doctrine\Assets;

use DateTime;

class SimpleEntityWithDateTime
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var DateTime
     */
    protected $date;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setDate(DateTime $date = null)
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }
}
