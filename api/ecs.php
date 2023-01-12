<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

require __DIR__ . '/vendor/autoload.php';

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths(
        [
            __DIR__ . '/src',
            __DIR__ . '/public',
            __DIR__ . '/tests',
            __DIR__ . '/ecs.php',
            __DIR__ . '/phinx.php',
            __DIR__ . '/database',
        ]
    );
    $ecsConfig->sets([
        SetList::CLEAN_CODE,
        SetList::COMMON,
        SetList::PSR_12,
    ]);
};
