<?php

/**
 * @see       https://github.com/laminas/laminas-doctrine-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-doctrine-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-doctrine-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Hydrator\Doctrine\Container;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManagerAware;
use Laminas\Hydrator\Doctrine\DoctrineHydrator;
use Laminas\Hydrator\Doctrine\DoctrineObject;
use Psr\Container\ContainerInterface;
use Laminas\Hydrator\AbstractHydrator;
use Laminas\Hydrator\Doctrine\Exception;
use Laminas\Hydrator\Filter\FilterComposite;
use Laminas\Hydrator\Filter\FilterInterface;
use Laminas\Hydrator\Filter\FilterEnabledInterface;
use Laminas\Hydrator\NamingStrategy\NamingStrategyInterface;
use Laminas\Hydrator\NamingStrategy\NamingStrategyEnabledInterface;
use Laminas\Hydrator\Strategy\StrategyInterface;
use Laminas\Hydrator\Strategy\StrategyEnabledInterface;

class DoctrineHydratorFactory
{
    /**
     * @param ContainerInterface $container
     * @param $requestedName
     * @return DoctrineHydrator
     * @throws Exception\ConfigurationException
     */
    public function __invoke(ContainerInterface $container, $requestedName)
    {
        $config = $container->get('config');
        $hydratorsConfig = $config['doctrine']['hydrators'];

        if (! isset($hydratorsConfig[$requestedName])) {
            throw new Exception\ConfigurationException(sprintf('Could not retrieve "%s" config', $requestedName));
        }

        $hydratorConfig = $hydratorsConfig[$requestedName];

        $objectManager = $this->loadObjectManager($container, $hydratorConfig);

        $extractService = null;
        $hydrateService = null;

        $useCustomHydrator = array_key_exists('hydrator', $hydratorConfig);

        if ($useCustomHydrator) {
            $extractService = $container->get($hydratorConfig['hydrator']);
            $hydrateService = $extractService;
        }

        if (! isset($extractService, $hydrateService)) {
            $doctrineHydrator = new DoctrineObject($objectManager, $hydratorConfig['by_value']);
            $extractService = ($extractService ?: $doctrineHydrator);
            $hydrateService = ($hydrateService ?: $doctrineHydrator);
        }


        $this->configureHydrator($extractService, $container, $hydratorConfig, $objectManager);
        $this->configureHydrator($hydrateService, $container, $hydratorConfig, $objectManager);

        return new DoctrineHydrator($extractService, $hydrateService);
    }

    /**
     * @param ContainerInterface $container
     * @param $config
     * @return EntityManagerInterface
     */
    private function loadObjectManager(ContainerInterface $container, $config) : EntityManagerInterface
    {
        return $container->get(EntityManagerInterface::class);
    }

    /**
     * @param AbstractHydrator $hydrator
     * @param ContainerInterface $container
     * @param array $config
     * @param ObjectManager $objectManager
     * @throws Exception\ConfigurationException
     */
    public function configureHydrator(
        AbstractHydrator $hydrator,
        ContainerInterface $container,
        array $config,
        ObjectManager $objectManager
    ) : void {
        $this->configureHydratorFilters($hydrator, $container, $config, $objectManager);
        $this->configureHydratorStrategies($hydrator, $container, $config, $objectManager);
        $this->configureHydratorNamingStrategy($hydrator, $container, $config, $objectManager);
    }

    /**
     * @param AbstractHydrator $hydrator
     * @param ContainerInterface $container
     * @param array $config
     * @param ObjectManager $objectManager
     * @throws Exception\ConfigurationException
     */
    public function configureHydratorFilters(
        AbstractHydrator $hydrator,
        ContainerInterface $container,
        array $config,
        ObjectManager $objectManager
    ) : void {
        if (! $hydrator instanceof FilterEnabledInterface
            || ! isset($config['filters'])
            || ! is_array($config['filters'])
        ) {
            return;
        }

        foreach ($config['filters'] as $name => $filterConfig) {
            $conditionMap = [
                'and' => FilterComposite::CONDITION_AND,
                'or' => FilterComposite::CONDITION_OR,
            ];

            $condition = isset($filterConfig['condition']) ?
                $conditionMap[$filterConfig['condition']] :
                FilterComposite::CONDITION_OR;

            $filterService = $filterConfig['filter'];

            if (! $container->has($filterService)) {
                throw new Exception\ConfigurationException(
                    sprintf('Invalid filter %s for field %s: service does not exist', $filterService, $name)
                );
            }

            $filterService = $container->get($filterService);

            if (! $filterService instanceof FilterInterface) {
                throw new Exception\ConfigurationException(
                    sprintf('Filter service %s must implement FilterInterface', get_class($filterService))
                );
            }

            if ($filterService instanceof ObjectManagerAware) {
                $filterService->setObjectManager($objectManager);
            }

            $hydrator->addFilter($name, $filterService, $condition);
        }
    }

    /**
     * @param AbstractHydrator $hydrator
     * @param ContainerInterface $container
     * @param array $config
     * @param ObjectManager $objectManager
     * @throws Exception\ConfigurationException
     */
    public function configureHydratorStrategies(
        AbstractHydrator $hydrator,
        ContainerInterface $container,
        array $config,
        ObjectManager $objectManager
    ) : void {
        if (! $hydrator instanceof StrategyEnabledInterface
            || ! isset($config['strategies'])
            || ! is_array($config['strategies'])
        ) {
            return;
        }

        foreach ($config['strategies'] as $field => $strategyKey) {
            if (! $container->has($strategyKey)) {
                throw new Exception\ConfigurationException(
                    sprintf('Invalid strategy %s for field %s', $strategyKey, $field)
                );
            }

            $strategy = $container->get($strategyKey);

            if (! $strategy instanceof StrategyInterface) {
                throw new Exception\ConfigurationException(
                    sprintf('Invalid strategy class %s for field %s', get_class($strategy), $field)
                );
            }

            if ($strategy instanceof ObjectManagerAware) {
                $strategy->setObjectManager($objectManager);
            }

            $hydrator->addStrategy($field, $strategy);
        }
    }

    /**
     * @param AbstractHydrator $hydrator
     * @param ContainerInterface $container
     * @param array $config
     * @param ObjectManager $objectManager
     * @throws Exception\ConfigurationException
     */
    public function configureHydratorNamingStrategy(
        AbstractHydrator $hydrator,
        ContainerInterface $container,
        array $config,
        ObjectManager $objectManager
    ) : void {
        if (! ($hydrator instanceof NamingStrategyEnabledInterface) || ! isset($config['naming_strategy'])) {
            return;
        }

        $namingStrategyKey = $config['naming_strategy'];

        if (! $container->has($namingStrategyKey)) {
            throw new Exception\ConfigurationException(sprintf('Invalid naming strategy %s.', $namingStrategyKey));
        }

        $namingStrategy = $container->get($namingStrategyKey);

        if (! $namingStrategy instanceof NamingStrategyInterface) {
            throw new Exception\ConfigurationException(
                sprintf('Invalid naming strategy class %s', get_class($namingStrategy))
            );
        }

        if ($namingStrategy instanceof ObjectManagerAware) {
            $namingStrategy->setObjectManager($objectManager);
        }

        $hydrator->setNamingStrategy($namingStrategy);
    }
}
