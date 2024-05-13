<?php

declare(strict_types=1);

/*
 * This file is part of the Contao Zammad Gateway extension.
 *
 * (c) Contao Academy
 *
 * @license LGPL-3.0-or-later
 */

$GLOBALS['TL_LANG']['tl_nc_message']['zammad_customer_legend'] = 'Zammad customer settings';
$GLOBALS['TL_LANG']['tl_nc_message']['zammad_ticket_legend'] = 'Zammad ticket settings';
$GLOBALS['TL_LANG']['tl_nc_message']['zammad_email'] = ['E-mail address', 'E-mail address with which to identify a customer (e.g. ##form_email##).'];
$GLOBALS['TL_LANG']['tl_nc_message']['zammad_params'] = ['Customer parameters', 'Parameters for the Zammad API when creating a new customer (recommended: firstname, lastname). Key = Zammad | Value = Contao'];
$GLOBALS['TL_LANG']['tl_nc_message']['zammad_title'] = ['Ticket title', "The text or simple token that should be used for the ticket's title (e.g. ##form_subject##)."];
$GLOBALS['TL_LANG']['tl_nc_message']['zammad_group'] = ['Ticket group', 'The Zammad group to which this ticket will be assigned.'];
$GLOBALS['TL_LANG']['tl_nc_message']['zammad_body'] = ['Message body', 'The message body for the ticket. Can contain text and simple tokens.'];
