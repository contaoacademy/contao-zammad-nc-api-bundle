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

$GLOBALS['TL_LANG']['tl_nc_gateway']['type'][ZammadGateway::NAME] = 'Zammad-API';
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammad_settings'] = 'Zammad-Einstellungen';
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadAuthType'] = ['Authentication Type', 'Bitte wählen Sie einen authentication type aus.'];
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadHost'] = ['Host', 'Bitte geben Sie die URL der verwendeten Zammad Instanz ein z.B https://yourname.zammad.com'];
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadUser'] = ['Benutzer', 'Bitte geben Sie Ihren zammad Benutzer ein.'];
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadPassword'] = ['Passwort', 'Bitte geben Sie Ihren zammad Passwort ein.'];
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadToken'] = ['Token', 'Bitte geben Sie Ihr zammad token ein.'];
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadAuthTypes']['token'] = 'Token';
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadAuthTypes']['basic'] = 'HTTP Basic Authentication';
