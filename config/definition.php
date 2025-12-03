<?php

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;

/**
 * @link https://symfony.com/doc/current/bundles/best_practices.html#configuration
 */
return static function (DefinitionConfigurator $definition): void {
    $definition
        ->rootNode()
            ->children()
                ->arrayNode('managers')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()

                            // ID storage služby; ak nie je zadané, použije sa defaultná storage aliasovaná na StorageInterface
                            ->scalarNode('storage')->defaultNull()->end()

                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end()
    ;
};
