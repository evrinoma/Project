<?php


namespace Evrinoma\ProjectBundle\DependencyInjection;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class EvrinomaProjectExtension
 *
 * @package Evrinoma\GridBundle\DependencyInjection
 */
class EvrinomaProjectExtension extends Extension
{
//region SECTION: Fields
    const ENTITY_BASE_PROJECT = 'Evrinoma\ProjectBundle\Entity\BaseProject';
    /**
     * @var array
     */
    private static $doctrineDrivers = array(
        'orm' => array(
            'registry' => 'doctrine',
            'tag'      => 'doctrine.event_subscriber',
        ),
    );
    /**
     * @var YamlFileLoader
     */
    private $lazyLoader;


    private $path;
//endregion Fields


//region SECTION: Protected
    protected function remapParameters(array $config, ContainerBuilder $container, array $map)
    {
        foreach ($map as $name => $paramName) {
            if (array_key_exists($name, $config)) {
                $container->setParameter($paramName, $config[$name]);
            }
        }
    }

    protected function remapParametersNamespaces(array $config, ContainerBuilder $container, array $namespaces)
    {
        foreach ($namespaces as $ns => $map) {
            if ($ns) {
                if (!array_key_exists($ns, $config)) {
                    continue;
                }
                $namespaceConfig = $config[$ns];
            } else {
                $namespaceConfig = $config;
            }
            if (is_array($map)) {
                $this->remapParameters($namespaceConfig, $container, $map);
            } else {
                foreach ($namespaceConfig as $name => $value) {
                    $container->setParameter(sprintf($map, $name), $value);
                }
            }
        }
    }
//endregion Protected

//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);


        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $loader->load('doctrine.yml');
            $container->setAlias('evrinoma.doctrine_registry', new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false));
        }
        $container->setParameter('evrinoma.'.$this->getAlias().'.backend_type_'.$config['db_driver'], true);

        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $definition = $container->getDefinition('evrinoma.object_manager');
            $definition->setFactory([new Reference('evrinoma.doctrine_registry'), 'getManager']);
        }

        $this->remapParametersNamespaces(
            $config,
            $container,
            [
                '' => [
                    'db_driver'           => 'evrinoma.storage',
                    'class'               => 'evrinoma.project.class',
                    'entity_manager_name' => 'evrinoma.entity_manager_name',
                ],
            ]
        );
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return 'project';
    }
//endregion Getters/Setters
}