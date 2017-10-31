<?php
/*
 * Copyright (C) 2004-2017 Soner Tari
 *
 * This file is part of UTMFW.
 *
 * UTMFW is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * UTMFW is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with UTMFW.  If not, see <http://www.gnu.org/licenses/>.
 */

/** @file
 * Snort IPS managed lists.
 */

$Reload= TRUE;
SetRefreshInterval();

if (count($_POST)) {
	if (filter_has_var(INPUT_POST, 'UnblockAll')) {
		$View->Controller($Output, 'UnblockAll');
	}
	else if (filter_has_var(INPUT_POST, 'Unblock')) {
		$View->Controller($Output, 'UnblockIPs', json_encode($_POST['ItemsToDelete']));
	}
	else if (filter_has_var(INPUT_POST, 'Block')) {
		$View->Controller($Output, 'BlockIP', filter_input(INPUT_POST, 'ItemToAdd'), filter_input(INPUT_POST, 'TimeToAdd'));
	}
}

require_once($VIEW_PATH.'/header.php');
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
	<table>
		<tr>
			<td>
				<?php echo _TITLE('Refresh interval').': ' ?><input type="text" name="RefreshInterval" style="width: 20px;" maxlength="2" value="<?php echo $_SESSION[$View->Model][$TopMenu]['ReloadRate'] ?>" />
				<?php echo ' '._TITLE('secs') ?>
				<input type="submit" name="Apply" value="<?php echo _CONTROL('Apply') ?>"/>
			</td>
		</tr>
	</table>
</form>
<table style="width: 500px;">
	<tr>
	<?php
	$View->PrintBlockedIPsForm();
	?>
	</tr>
</table>
<?php
PrintHelpWindow(_HELPWINDOW('This page displays the hosts managed by the IPS, i.e. blocked or unblocked IPs or networks. You can temporarily block hosts for a period of time. If expiration time is not provided, the default duration is used. You can enter individual IPs or network addresses. IP and network addresses can overlap.

This page reloads automatically to update the managed list. If the IPS is not running, the page displays blank.'));
require_once($VIEW_PATH.'/footer.php');
?>
