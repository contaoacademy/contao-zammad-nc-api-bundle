<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Zammad Gateway extension.
 *
 * (c) Contao Academy
 *
 * @license LGPL-3.0-or-later
 */

namespace ContaoAcademy\ZammadNCApiBundle\Parcel\Stamp;

use ContaoAcademy\ZammadNCApiBundle\Config\ZammadMessageConfig;
use Terminal42\NotificationCenterBundle\Parcel\Stamp\AbstractConfigStamp;
use Terminal42\NotificationCenterBundle\Parcel\Stamp\StampInterface;

class ZammadMessageStamp extends AbstractConfigStamp
{
    public function __construct(public ZammadMessageConfig $zammadMessageConfig)
    {
        parent::__construct($this->zammadMessageConfig);
    }

    public static function fromArray(array $data): StampInterface
    {
        return new self(ZammadMessageConfig::fromArray($data));
    }
}
