<?php
/* <one line to give the program's name and a brief idea of what it does.>
 * Copyright (C) 2015 ATM Consulting <support@atm-consulting.fr>
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

/**
 * 	\file		admin/sendinvoicetoadherent.php
 * 	\ingroup	sendinvoicetoadherent
 * 	\brief		This file is an example module setup page
 * 				Put some comments here
 */
// Dolibarr environment
$res = @include("../../main.inc.php"); // From htdocs directory
if (! $res) {
    $res = @include("../../../main.inc.php"); // From "custom" directory
}

// Libraries
require_once DOL_DOCUMENT_ROOT . "/core/lib/admin.lib.php";
require_once '../lib/sendinvoicetoadherent.lib.php';

// Translations
$langs->load("sendinvoicetoadherent@sendinvoicetoadherent");

// Access control
if (! $user->admin) {
    accessforbidden();
}

// Parameters
$action = GETPOST('action', 'alpha');

/*
 * Actions
 */
if (preg_match('/set_(.*)/',$action,$reg))
{
	$code=$reg[1];
	if (dolibarr_set_const($db, $code, GETPOST($code), 'chaine', 0, '', $conf->entity) > 0)
	{
		header("Location: ".$_SERVER["PHP_SELF"]);
		exit;
	}
	else
	{
		dol_print_error($db);
	}
}
	
if (preg_match('/del_(.*)/',$action,$reg))
{
	$code=$reg[1];
	if (dolibarr_del_const($db, $code, 0) > 0)
	{
		Header("Location: ".$_SERVER["PHP_SELF"]);
		exit;
	}
	else
	{
		dol_print_error($db);
	}
}

/*
 * View
 */
$page_name = "sendinvoicetoadherentSetup";
llxHeader('', $langs->trans($page_name));

// Subheader
$linkback = '<a href="' . DOL_URL_ROOT . '/admin/modules.php">'
    . $langs->trans("BackToModuleList") . '</a>';
print_fiche_titre($langs->trans($page_name), $linkback);

// Configuration header
$head = sendinvoicetoadherentAdminPrepareHead();
dol_fiche_head(
    $head,
    'settings',
    $langs->trans("Module104710Name"),
    0,
    "sendinvoicetoadherent@sendinvoicetoadherent"
);

// Setup page goes here
$form=new Form($db);
$var=false;
print '<table class="noborder" width="100%">';
print '<tr class="liste_titre">';
print '<td width="30%">'.$langs->trans("Parameters").'</td>'."\n";
print '<td align="center" width="20%">&nbsp;</td>';
print '<td align="right" width="50%">'.$langs->trans("Value").'&nbsp;</td>'."\n";

$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("sendinvoicetoadherent_fk_facture").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="right" width="300">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
print '<input type="hidden" name="action" value="set_SENDINVOICETOADHERENT_FK_FACTURE">';
print '<input type="text" name="SENDINVOICETOADHERENT_FK_FACTURE" value="'.$conf->global->SENDINVOICETOADHERENT_FK_FACTURE.'" />';
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</form>';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("sendinvoicetoadherent_subject").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="right" width="300">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
print '<input type="hidden" name="action" value="set_SENDINVOICETOADHERENT_SUBJECT">';
print '<input size="62" type="text" name="SENDINVOICETOADHERENT_SUBJECT" value="'.$conf->global->SENDINVOICETOADHERENT_SUBJECT.'" />';
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</form>';
print '</td></tr>';

$var=!$var;
print '<tr '.$bc[$var].'>';
print '<td>'.$langs->trans("sendinvoicetoadherent_message").'</td>';
print '<td align="center" width="20">&nbsp;</td>';
print '<td align="right" width="300">';
print '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
print '<input type="hidden" name="action" value="set_SENDINVOICETOADHERENT_MESSAGE">';
print img_picto($langs->trans('SENDINVOICETOADHERENT_SUBJECT_HELP'), 'info.png').'<textarea cols="60" rows="5" style="vertical-align:middle;" name="SENDINVOICETOADHERENT_MESSAGE">'.$conf->global->SENDINVOICETOADHERENT_MESSAGE.'</textarea>';
print '<input type="submit" class="button" value="'.$langs->trans("Modify").'">';
print '</form>';
print '</td></tr>';

print '</table>';

llxFooter();

$db->close();