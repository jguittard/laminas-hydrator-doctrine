<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Hydrator\Doctrine\Assets;

class SimplePrivateEntity
{
    private function setPrivate($value)
    {
        throw new \Exception('Should never be called');
    }

    private function getPrivate()
    {
        throw new \Exception('Should never be called');
    }

    protected function setProtected($value)
    {
        throw new \Exception('Should never be called');
    }

    protected function getProtected()
    {
        throw new \Exception('Should never be called');
    }
}
