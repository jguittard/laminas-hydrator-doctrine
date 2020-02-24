<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\Hydrator\Doctrine;

use Laminas\Hydrator\Doctrine\DoctrineHydrator;
use Laminas\Hydrator\HydratorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DoctrineHydratorTest extends TestCase
{
    /**
     * @var HydratorInterface|MockObject
     */
    private $extractService;

    /**
     * @var HydratorInterface|MockObject
     */
    private $hydrateService;

    /**
     * @var array
     */
    private $extractData;

    /**
     * @var \stdClass
     */
    private $hydrateObject;

    /**
     * @var DoctrineHydrator
     */
    private $hydrator;

    protected function setUp(): void
    {

        $this->extractData = ['foo' => 'bar'];
        $this->hydrateObject = new \stdClass();

        $this->extractService = $this->createMock(HydratorInterface::class);
        $this->extractService->expects($this->any())
            ->method('extract')
            ->with($this->hydrateObject)
            ->willReturn($this->extractData);

        $this->hydrateService = $this->createMock(HydratorInterface::class);
        $this->hydrateService->expects($this->any())
            ->method('hydrate')
            ->with($this->extractData, $this->hydrateObject)
            ->willReturn($this->hydrateObject);

        $this->hydrator = new DoctrineHydrator($this->extractService, $this->hydrateService);
    }

    public function testInjection()
    {
        $this->assertSame($this->extractService, $this->hydrator->getExtractService());
        $this->assertSame($this->hydrateService, $this->hydrator->getHydrateService());
    }

    public function testExtract()
    {
        $this->assertSame($this->extractData, $this->hydrator->extract($this->hydrateObject));
    }

    public function testHydrate()
    {
        $this->assertSame($this->hydrateObject, $this->hydrator->hydrate($this->extractData, $this->hydrateObject));
    }
}
