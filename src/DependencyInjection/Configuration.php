<?php

namespace Evrinoma\ProjectBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Evrinoma\ProjectBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('project');
        $rootNode    = $treeBuilder->getRootNode();
        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('db_driver')
                    ->validate()
                        ->ifNotInArray($supportedDrivers)
                        ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
                    ->end()
                    ->cannotBeOverwritten()
                    ->defaultValue('orm')
                ->end()
                ->scalarNode('class')
            //->isRequired()
            ->cannotBeEmpty()->defaultValue(EvrinomaProjectExtension::ENTITY_BASE_PROJECT)->end()
                ->scalarNode('entity_manager_name')->defaultNull()->end()
            ->end();

        return $treeBuilder;
    }
}
