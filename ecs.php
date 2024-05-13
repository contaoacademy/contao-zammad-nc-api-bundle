<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->sets([__DIR__.'/vendor/contao/easy-coding-standard/config/contao.php']);

    $ecsConfig->paths([
        __DIR__.'/src',
        __DIR__.'/contao',
    ]);

    $ecsConfig->ruleWithConfiguration(HeaderCommentFixer::class, [
        'header' => "This file is part of the Contao Zammad Gateway extension.\n\n(c) Contao Academy\n\n@license LGPL-3.0-or-later",
    ]);

    $ecsConfig->parallel();
    $ecsConfig->lineEnding("\n");
    $ecsConfig->cacheDirectory(sys_get_temp_dir().'/ecs_default_cache');
};
