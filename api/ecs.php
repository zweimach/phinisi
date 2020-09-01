<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

require __DIR__ . '/vendor/autoload.php';

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(
        'paths',
        [
            __DIR__ . '/src',
            __DIR__ . '/public',
            __DIR__ . '/tests',
            __DIR__ . '/ecs.php',
            __DIR__ . '/phinx.php',
            __DIR__ . '/database'
        ]
    );
    $parameters->set(
        'sets',
        [
            'clean-code',
            'comments',
            'control-structures',
            'dead-code',
            'docblock',
            'namespaces',
            'php-70',
            'php-71',
            'psr-12',
            'strict',
            'symplify'
        ]
    );
    $parameters->set('skip', [
        'SlevomatCodingStandard\Sniffs\PHP\DisallowDirectMagicInvokeCallSniff.DisallowDirectMagicInvokeCall' => [
            'src/Shared/ShutdownHandler.php'
        ]
    ]);
};
