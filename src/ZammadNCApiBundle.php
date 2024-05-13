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

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ZammadNCApiBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
