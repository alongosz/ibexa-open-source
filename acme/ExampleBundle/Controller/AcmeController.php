<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Acme\ExampleBundle\Controller;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use eZ\Publish\Core\MVC\Symfony\SiteAccess\SiteAccessServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class AcmeController extends AbstractController
{
    private ConfigResolverInterface $configResolver;

    private SiteAccessServiceInterface $siteAccessService;

    public function __construct(
        ConfigResolverInterface $configResolver,
        SiteAccessServiceInterface $siteAccessService
    ) {
        $this->configResolver = $configResolver;
        $this->siteAccessService = $siteAccessService;
    }

    public function helloAction(): Response
    {
        $config = [
            'site_access' => $this->siteAccessService->getCurrent()->name,
            'name' => $this->configResolver->getParameter('name', 'acme_example'),
            'custom_setting' => $this->configResolver->getParameter(
                'custom_setting',
                'acme_example'
            ),
        ];

        return new Response(var_export($config, true), 200, ['Content-Type' => 'text/plain']);
    }
}
