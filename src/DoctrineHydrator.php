<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Hydrator\Doctrine;

use Laminas\Hydrator\HydratorInterface;

class DoctrineHydrator implements HydratorInterface
{
    /**
     * @var HydratorInterface
     */
    protected $extractService;

    /**
     * @var HydratorInterface
     */
    protected $hydrateService;

    /**
     * DoctrineHydrator constructor.
     *
     * @param HydratorInterface $extractService
     * @param HydratorInterface $hydrateService
     */
    public function __construct(HydratorInterface $extractService, HydratorInterface $hydrateService)
    {
        $this->extractService = $extractService;
        $this->hydrateService = $hydrateService;
    }

    /**
     * @return HydratorInterface
     */
    public function getExtractService(): HydratorInterface
    {
        return $this->extractService;
    }

    /**
     * @return HydratorInterface
     */
    public function getHydrateService(): HydratorInterface
    {
        return $this->hydrateService;
    }

    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract(object $object): array
    {
        return $this->extractService->extract($object);
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        return $this->hydrateService->hydrate($data, $object);
    }
}
