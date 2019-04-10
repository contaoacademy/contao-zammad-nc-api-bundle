<?php

$GLOBALS['TL_DCA']['tl_nc_message']['palettes']['zammad'] = '{title_legend},title,gateway;{zammad_legend},zammad_group';


$GLOBALS['TL_DCA']['tl_nc_message']['fields']['zammad_group'] = [

    'label' => &$GLOBALS['TL_LANG']['tl_nc_message']['zammad_group'],
    'exclude' => true,
    'inputType' => 'text',
    'default' => '',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "varchar(64) NOT NULL default ''"
];