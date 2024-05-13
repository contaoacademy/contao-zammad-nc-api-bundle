<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Zammad Gateway extension.
 *
 * (c) Contao Academy
 *
 * @license LGPL-3.0-or-later
 */

use ContaoAcademy\ZammadNCApiBundle\Gateway\ZammadGateway;

$GLOBALS['TL_DCA']['tl_nc_gateway']['palettes']['__selector__'][] = 'zammadAuthType';
$GLOBALS['TL_DCA']['tl_nc_gateway']['palettes'][ZammadGateway::NAME] = '{title_legend},title,type;{gateway_legend},zammadHost,zammadAuthType';
$GLOBALS['TL_DCA']['tl_nc_gateway']['subpalettes']['zammadAuthType_basic'] = 'zammadUser,zammadPassword';
$GLOBALS['TL_DCA']['tl_nc_gateway']['subpalettes']['zammadAuthType_token'] = 'zammadToken';

$GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['zammadHost'] = [
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 255,
        'rgxp' => 'httpurl',
        'mandatory' => true,
    ],
    'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['zammadAuthType'] = [
    'inputType' => 'select',
    'eval' => [
        'tl_class' => 'clr w50',
        'submitOnChange' => true,
        'includeBlankOption' => true,
        'mandatory' => true,
    ],
    'options' => ['basic', 'token'],
    'reference' => &$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadAuthTypes'],
    'exclude' => true,
    'sql' => ['type' => 'string', 'length' => 8, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['zammadToken'] = [
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 255,
        'mandatory' => true,
    ],
    'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['zammadUser'] = [
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 255,
        'mandatory' => true,
    ],
    'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_nc_gateway']['fields']['zammadPassword'] = [
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50',
        'maxlength' => 255,
        'mandatory' => true,
    ],
    'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
];
