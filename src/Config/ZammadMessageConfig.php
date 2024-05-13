<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Zammad Gateway extension.
 *
 * (c) Contao Academy
 *
 * @license LGPL-3.0-or-later
 */

namespace ContaoAcademy\ZammadNCApiBundle\Config;

use Terminal42\NotificationCenterBundle\Config\AbstractConfig;

class ZammadMessageConfig extends AbstractConfig
{
    public function getEmail(): string
    {
        return $this->getString('email');
    }

    public function getParameters(): array
    {
        return $this->get('parameters', []);
    }

    public function getTitle(): string
    {
        return $this->getString('title');
    }

    public function getGroup(): string
    {
        return $this->getString('group');
    }

    public function getBody(): string
    {
        return $this->getString('body');
    }
}
