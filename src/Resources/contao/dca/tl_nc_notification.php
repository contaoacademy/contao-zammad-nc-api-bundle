<?php

$GLOBALS['TL_DCA']['tl_nc_notification']['palettes']['core_form'] = str_replace( 'templates', 'templates;{zammad_legend},zammad_group', $GLOBALS['TL_DCA']['tl_nc_notification']['palettes']['core_form'] );

$GLOBALS['TL_DCA']['tl_nc_notification']['fields']['zammad_group'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_nc_notification']['zammad_group'],
    'exclude' => true,
    'inputType' => 'text',
    'default' => '',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "varchar(64) NOT NULL default ''"
];