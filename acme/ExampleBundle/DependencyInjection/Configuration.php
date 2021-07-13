<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Acme\ExampleBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration as SiteAccessConfiguration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration extends SiteAccessConfiguration
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('acme_example');
        $rootNode = $treeBuilder->getRootNode();

        // $systemNode is the root of SiteAccess-aware settings.
        $systemNode = $this->generateScopeBaseNode($rootNode);
        $systemNode
            ->scalarNode('name')->isRequired()->end()
            ->arrayNode('custom_setting')
                ->children()
                    ->scalarNode('string')->end()
                    ->integerNode('number')->end()
                    ->booleanNode('enabled')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
