<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Zammad Gateway extension.
 *
 * (c) Contao Academy
 *
 * @license LGPL-3.0-or-later
 */

use Doctrine\DBAL\Platforms\MySQLPlatform;
use Terminal42\NotificationCenterBundle\Token\TokenContext;

$GLOBALS['TL_DCA']['tl_nc_message']['fields']['zammad_email'] = [
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'clr w50'],
    'exclude' => true,
    'nc_context' => TokenContext::Email,
    'sql' => ['type' => 'string', 'length' => 255, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_nc_message']['fields']['zammad_params'] = [
    'exclude' => true,
    'inputType' => 'keyValueWizard',
    'eval' => ['tl_class' => 'clr'],
    'sql' => ['type' => 'blob', 'notnull' => false],
];

$GLOBALS['TL_DCA']['tl_nc_message']['fields']['zammad_title'] = [
    'exclude' => true,
    'inputType' => 'text',
    'default' => '',
    'eval' => ['tl_class' => 'w50', 'maxlength' => 64, 'mandatory' => true],
    'nc_context' => TokenContext::Text,
    'sql' => ['type' => 'string', 'length' => 64, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_nc_message']['fields']['zammad_group'] = [
    'exclude' => true,
    'inputType' => 'text',
    'default' => '',
    'eval' => ['tl_class' => 'w50', 'maxlength' => 64, 'mandatory' => true],
    'nc_context' => TokenContext::Text,
    'sql' => ['type' => 'string', 'length' => 64, 'default' => ''],
];

$GLOBALS['TL_DCA']['tl_nc_message']['fields']['zammad_body'] = [
    'exclude' => true,
    'inputType' => 'textarea',
    'default' => '',
    'eval' => ['mandatory' => true, 'tl_class' => 'clr'],
    'nc_context' => TokenContext::Html,
    'sql' => ['type' => 'text', 'length' => MySQLPlatform::LENGTH_LIMIT_TEXT, 'notnull' => false],
];

$GLOBALS['TL_DCA']['tl_nc_message']['palettes']['zammad'] = '{title_legend},title,gateway;{zammad_customer_legend},zammad_email,zammad_params;{zammad_ticket_legend},zammad_title,zammad_group,zammad_body;{publish_legend},published';
