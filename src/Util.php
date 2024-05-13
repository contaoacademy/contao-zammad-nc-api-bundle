<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Zammad Gateway extension.
 *
 * (c) Contao Academy
 *
 * @license LGPL-3.0-or-later
 */

namespace ContaoAcademy\ZammadNCApiBundle;

use Codefog\HasteBundle\StringParser;
use Haste\Util\StringUtil;

class Util
{
    /**
     * Compatibility layer to support both codefog/contao-haste v4 and v5.
     */
    public static function recursiveReplaceTokensAndTags(string $text, array $tokens, int $textFlags = 0): string
    {
        if (class_exists(StringParser::class)) {
            return (new StringParser())->recursiveReplaceTokensAndTags($text, $tokens, $textFlags);
        }

        return StringUtil::recursiveReplaceTokensAndTags($text, $tokens, $textFlags);
    }
}
