<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Acme\ExampleBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ConfigurationProcessor;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ContextualizerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AcmeExampleExtension extends Extension
{
    public const ACME_CONFIG_DIR = __DIR__ . '/../../../config/acme';

    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(self::ACME_CONFIG_DIR));
        $loader->load('default_settings.yaml');

        $processor = new ConfigurationProcessor($container, 'acme_example');
        $processor->mapConfig(
            $config,
            // Any kind of callable can be used here.
            // It is called for each declared scope/SiteAccess.
            static function ($scopeSettings, $currentScope, ContextualizerInterface $contextualizer) {
                // Maps the "name" setting to "acme_example.<$currentScope>.name" container parameter
                // It is then possible to retrieve this parameter through ConfigResolver in the application code:
                // $helloSetting = $configResolver->getParameter( 'name', 'acme_example' );
                $contextualizer->setContextualParameter('name', $currentScope, $scopeSettings['name']);
            }
        );

        // Now map "custom_setting" and ensure the key defined for "my_siteaccess" overrides the one for "my_siteaccess_group"
        // It is done outside the closure as it is needed only once.
        $processor->mapConfigArray('custom_setting', $config);
    }
}
