<?php

use Ibexa\CodeStyle\PhpCsFixer\InternalConfigFactory;

return InternalConfigFactory::build()
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in([__DIR__ . '/src', __DIR__ . '/tests'])
            ->files()->name('*.php')
    )
    ;
