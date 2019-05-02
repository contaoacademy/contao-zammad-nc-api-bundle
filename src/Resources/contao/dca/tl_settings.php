<?php

$GLOBALS['TL_DCA']['tl_settings']['palettes']['__selector__'][] = 'zammadAuthType';
$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{zammad_settings},zammadAuthType';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['zammadAuthType_basic'] = 'zammadHost,zammadUser,zammadPassword';
$GLOBALS['TL_DCA']['tl_settings']['subpalettes']['zammadAuthType_token'] = 'zammadHost,zammadToken';


$GLOBALS['TL_DCA']['tl_settings']['fields']['zammadAuthType'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_settings']['zammadAuthType'],
    'inputType' => 'radio',
    'eval' => [
        'tl_class' => 'clr',
        'submitOnChange' => true,
    ],
    'options' => [ 'basic', 'token' ],
    'reference' => &$GLOBALS['TL_LANG']['tl_settings']['reference']['zammadAuthType'],
    'exclude' => true
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['zammadToken'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_settings']['zammadToken'],
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50'
    ]
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['zammadHost'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_settings']['zammadHost'],
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50'
    ]
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['zammadUser'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_settings']['zammadUser'],
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50'
    ]
];

$GLOBALS['TL_DCA']['tl_settings']['fields']['zammadPassword'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_settings']['zammadPassword'],
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50'
    ]
];