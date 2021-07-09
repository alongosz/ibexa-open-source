<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ConfigurationProcessor;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ContextualizerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AppExtension extends Extension
{
    public function getAlias(): string
    {
        return 'app';
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $processor = new ConfigurationProcessor($container, 'app');
        $processor->mapConfig(
            $config,
            static function (
                $scopeSettings,
                $currentScope,
                ContextualizerInterface $contextualizer
            ): void {
                $contextualizer->setContextualParameter(
                    'name',
                    $currentScope,
                    $scopeSettings['name']
                );
            }
        );

        $processor->mapConfigArray('custom_setting', $config);
    }
}
