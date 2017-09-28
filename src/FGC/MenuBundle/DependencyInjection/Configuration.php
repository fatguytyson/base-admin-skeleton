<?php

namespace FGC\MenuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fgc_menu');

        $rootNode
            ->children()
                ->scalarNode('directory')
                    ->info('The path for the @Menu Annotation to look.')
                    ->defaultValue('AppBundle/Controller')
                ->end()
                ->scalarNode('namespace')
                    ->info('The Namespace for the @Menu Annotation to apply.')
                    ->defaultValue('AppBundle\Controller')
                ->end()
                ->arrayNode('menus')
                    ->info('Menu structures for routes outside of your src.')
                    ->defaultValue(array())
                    ->useAttributeAsKey('group')
                    ->arrayPrototype()
                        ->info('Group name and a way to call each menu easily.')
                        ->useAttributeAsKey('name')
                        ->arrayPrototype()
                        ->children()
                            ->scalarNode('route')
                                ->info('Route Name to generate path.')
                            ->end()
                            ->arrayNode('routeOptions')
                                ->info('Route options if route needs it.')
                            ->end()
                            ->scalarNode('icon')
                                ->info('Icon name to add in dashboard menus.')
                            ->end()
                            ->integerNode('order')
                                ->min(0)
                                ->info('Order of the menu item so Annotations can be adde in.')
                            ->end()
                            ->scalarNode('role')
                                ->info('A single ROLE to show only if is_granted() or none to always show.')
                            ->end()
                            ->scalarNode('children')
                                ->info('Menu name to place under this item.')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
