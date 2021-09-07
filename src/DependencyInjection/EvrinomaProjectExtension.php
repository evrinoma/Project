<?php


namespace Evrinoma\ProjectBundle\DependencyInjection;

use Evrinoma\ProjectBundle\EvrinomaProjectBundle;
use Evrinoma\UtilsBundle\DependencyInjection\HelperTrait;
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
    use HelperTrait;
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
//endregion Fields

//region SECTION: Public
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $configuration = $this->getConfiguration($configs, $container);
        $config        = $this->processConfiguration($configuration, $configs);


        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $loader->load('doctrine.yml');
            $container->setAlias('evrinoma.'.$this->getAlias().'.doctrine_registry', new Alias(self::$doctrineDrivers[$config['db_driver']]['registry'], false));
        }
        $container->setParameter('evrinoma.'.$this->getAlias().'.backend_type_'.$config['db_driver'], true);

        if (isset(self::$doctrineDrivers[$config['db_driver']])) {
            $definition = $container->getDefinition('evrinoma.'.$this->getAlias().'.object_manager');
            $definition->setFactory([new Reference('evrinoma.'.$this->getAlias().'.doctrine_registry'), 'getManager']);
        }

        $this->remapParametersNamespaces(
            $container,
            $config,
            [
                '' => [
                    'db_driver'           => 'evrinoma.'.$this->getAlias().'.storage',
                    'class'               => 'evrinoma.'.$this->getAlias().'.class',
                    'entity_manager_name' => 'evrinoma.'.$this->getAlias().'.entity_manager_name',
                ],
            ]
        );
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getAlias()
    {
        return EvrinomaProjectBundle::PROJECT_BUNDLE;
    }
//endregion Getters/Setters
}