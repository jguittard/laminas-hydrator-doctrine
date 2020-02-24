<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Hydrator\Doctrine\Exception;

use Exception as SplException;
use Psr\Container\ContainerExceptionInterface;

class ConfigurationException extends SplException implements ContainerExceptionInterface
{

}
