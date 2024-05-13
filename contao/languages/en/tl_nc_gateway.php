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

$GLOBALS['TL_LANG']['tl_nc_gateway']['type'][ZammadGateway::NAME] = 'Zammad API';
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammad_settings'] = 'Zammad settings';
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadAuthType'] = ['Authentication type', 'Choose the authentication type for the Zammad API.'];
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadHost'] = ['Host', 'Enter the URL of the Zammad instance, e.g. https://yourname.zammad.com'];
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadUser'] = ['Username', 'Enter the username for the authentication.'];
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadPassword'] = ['Password', 'Enter the password for the authentiaction.'];
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadToken'] = ['Token', 'Enter the token for the authentication.'];
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadAuthTypes']['token'] = 'Token';
$GLOBALS['TL_LANG']['tl_nc_gateway']['zammadAuthTypes']['basic'] = 'HTTP Basic Authentication';
