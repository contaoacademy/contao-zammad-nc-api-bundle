<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Zammad Gateway extension.
 *
 * (c) Contao Academy
 *
 * @license LGPL-3.0-or-later
 */

namespace ContaoAcademy\ZammadNCApiBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use ContaoAcademy\ZammadNCApiBundle\ZammadNCApiBundle;
use Terminal42\NotificationCenterBundle\Terminal42NotificationCenterBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ZammadNCApiBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class, Terminal42NotificationCenterBundle::class]),
        ];
    }
}
