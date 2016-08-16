<?php
/* Send logs to a Sentry server
 * Copyright (C) 2016  Raphaël Doursenaud <rdoursenaud@gpcsolutions.fr>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

// Load Dolibarr environment
if (false === (@include '../../main.inc.php')) {  // From htdocs directory
	require '../../../main.inc.php'; // From "custom" directory
}

global $langs, $user;

// Libraries
require_once DOL_DOCUMENT_ROOT . "/core/lib/admin.lib.php";
require_once '../lib/sentry.lib.php';

require __DIR__ . '/../vendor/autoload.php';

//require_once "../class/myclass.class.php";
// Translations
$langs->load("sentry@sentry");

// Access control
if (! $user->admin) {
	accessforbidden();
}

// Parameters
$action = GETPOST('action', 'alpha');

/*
 * Actions
 */

/*
 * View
 */
$page_name = "SentryAbout";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php">'
	. $langs->trans("BackToModuleList") . '</a>';
print_fiche_titre($langs->trans($page_name), $linkback);

// Configuration header
$head = sentryAdminPrepareHead();
dol_fiche_head(
	$head,
	'about',
	$langs->trans("Module105009Name"),
	0,
	'sentry@sentry'
);

// About page goes here
echo $langs->trans("SentryAboutPage");

echo '<br>';

$buffer = file_get_contents(dol_buildpath('/sentry/README.md', 0));
echo Parsedown::instance()->text($buffer);

echo '<br>',
'<a href="' . dol_buildpath('/sentry/COPYING', 1) . '">',
'<img src="' . dol_buildpath('/sentry/img/gplv3.png', 1) . '"/>',
'</a>';


// Page end
dol_fiche_end();
llxFooter();