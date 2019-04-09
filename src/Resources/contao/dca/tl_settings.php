<?php

$GLOBALS['TL_DCA']['tl_settings']['palettes']['default'] .= ';{zammad_settings},zammadHost,zammadUser,zammadPassword';

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