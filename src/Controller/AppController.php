<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Controller;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class AppController extends AbstractController
{
    private ConfigResolverInterface $configResolver;

    public function __construct(ConfigResolverInterface $configResolver)
    {
        $this->configResolver = $configResolver;
    }

    public function helloAction(): Response
    {
        $config = [
            'name' => $this->configResolver->getParameter('name', 'app'),
            'custom_setting' => $this->configResolver->getParameter('custom_setting', 'app'),
        ];

        return new Response(var_export($config, true), 200, ['Content-Type' => 'text/plain']);
    }
}
