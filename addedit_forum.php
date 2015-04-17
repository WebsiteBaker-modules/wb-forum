<?php
/*

 Website Baker Project <http://www.websitebaker.org/>
 Copyright (C) 2004-2008, Ryan Djurovich

 Website Baker is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Website Baker is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Website Baker; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

require('../../config.php');
require(WB_PATH . '/modules/admin.php');

include_once(WB_PATH .'/framework/module.functions.php');

if(!file_exists(WB_PATH . '/modules/forum/languages/' . LANGUAGE . '.php')) {
	require_once(WB_PATH . '/modules/forum/languages/EN.php');
} else {
	require_once(WB_PATH . '/modules/forum/languages/' . LANGUAGE . '.php');
}

if (isset($_REQUEST['forumid'])) {
	$forum = $database->query("SELECT * FROM " . TABLE_PREFIX . "mod_forum_forum WHERE forumid = '" . intval($_REQUEST['forumid']) . "' AND section_id = '$section_id' AND page_id = '$page_id'");
	if (!$forum->numRows()) {
		$admin->print_error('Forum ungültig!', ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id);
	}
	$forum = $forum->fetchRow();
}

require_once(WB_PATH . '/modules/forum/backend.php');
?>

<h2><?php echo (isset($forum['forumid']) ? $MOD_FORUM['TXT_EDIT_FORUM_B'].' - '.$forum['title'] : $MOD_FORUM['TXT_CREATE_FORUM_B']); ?></h2>

<form name="modify" action="<?php echo WB_URL; ?>/modules/forum/insertupdate_forum.php" method="post" style="margin: 0;">

<table class="row_a" cellpadding="2" cellspacing="0" border="0" align="center" width="100%" style="margin-top: 5px;">
	<tr>
		<td colspan="2"><strong><?php echo $MOD_FORUM['TXT_SETTINGS_B']; ?></strong></td>
	</tr>
	<tr>
		<td class="setting_name" width="100"><?php echo $MOD_FORUM['TXT_TITLE_B']; ?></td>
		<td class="setting_name">
			<input type="text" name="title" style="width: 500px;" value="<?php echo (isset($forum['title']) ? htmlspecialchars($forum['title']) : ''); ?>" />
		</td>
	</tr>
	<tr>
		<td class="setting_name"><?php echo $MOD_FORUM['TXT_DESCRIPTION_B']; ?></td>
		<td class="setting_name">
			<textarea name="description" style="width: 500px; height: 140px;"><?php echo (isset($forum['description']) ? htmlspecialchars($forum['description']) : ''); ?></textarea>
		</td>
	</tr>
	<tr>
		<td class="setting_name"><?php echo $MOD_FORUM['TXT_DISPLAY_ORDER_B']; ?></td>
		<td class="setting_name">
			<input type="text" name="displayorder" style="width: 500px;" value="<?php echo (isset($forum['displayorder']) ? $forum['displayorder'] : ''); ?>" />
		</td>
	</tr>
	
	<tr>
		<td class="setting_name"><?php echo $MOD_FORUM['TXT_PARENT_FORUM_B'];?></td>
		<td class="setting_name">
			<select name="parentid" style="width: 500px;">
				<option value="0"> - </option>
				<?php
				print_forum_select_options(isset($forum) ? $forum['parentid'] : "");
				?>
			</select>
		</td>
	</tr>
	<?php
	if (isset($forum['forumid']))	{
	?>
		<tr>
			<td class="setting_name"><?php echo $MOD_FORUM['TXT_DELETE_B']; ?></td>
			<td class="setting_name">
				<input type="checkbox" name="delete" value="1" id="cb_delete" />
				<label for="cb_delete"><?php echo $MOD_FORUM['TXT_DELETE_FORUM_B']; ?></label>
			</td>
		</tr>
	<?php
	}
	?>
</table>

<table class="row_a" cellpadding="2" cellspacing="0" border="0" align="center" width="100%" style="margin-top: 5px;">
	<tr>
		<td colspan="2"><strong><?php echo $MOD_FORUM['TXT_PERMISSIONS_B']; ?></strong></td>
	</tr>
	<tr>
		<td class="setting_name" width="100"><?php echo $MOD_FORUM['TXT_READ_B']; ?></td>
		<td class="setting_name">
			<select name="readaccess">
				<option value="reg"<?php echo (isset($forum['readaccess']) && $forum['readaccess'] == 'reg' ? ' selected="selected"' : '');  ?>><?php echo $MOD_FORUM['TXT_REGISTRATED_B']; ?></option>
				<option value="unreg"<?php echo (isset($forum['readaccess']) && $forum['readaccess'] == 'unreg' ? ' selected="selected"' : '');  ?>><?php echo $MOD_FORUM['TXT_NOT_REGISTRATED_B']; ?></option>
				<option value="both"<?php echo (isset($forum['readaccess']) && $forum['readaccess'] == 'both' ? ' selected="selected"' : '');  ?>><?php echo $MOD_FORUM['TXT_BOTH_B']; ?></option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="setting_name"><?php echo $MOD_FORUM['TXT_WRITE_B']; ?></td>
		<td class="setting_name">
			<select name="writeaccess">
				<option value="reg"<?php echo (isset($forum['writeaccess']) && $forum['writeaccess'] == 'reg' ? ' selected="selected"' : '');  ?>><?php echo $MOD_FORUM['TXT_REGISTRATED_B']; ?></option>
				<option value="unreg"<?php echo (isset($forum['writeaccess']) && $forum['writeaccess'] == 'unreg' ? ' selected="selected"' : '');  ?>><?php echo $MOD_FORUM['TXT_NOT_REGISTRATED_B']; ?></option>
				<option value="both"<?php echo (isset($forum['writeaccess']) && $forum['writeaccess'] == 'both' ? ' selected="selected"' : '');  ?>><?php echo $MOD_FORUM['TXT_BOTH_B']; ?></option>
			</select>
		</td>
	</tr>
</table>

<input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
<input type="hidden" name="forumid" value="<?php echo (isset($forum['forumid']) ? $forum['forumid'] : ''); ?>">

<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td align="left">
			<input name="save" type="submit" value="<?php echo $MOD_FORUM['TXT_SAVE_B']; ?>" style="width: 150; margin-top: 5px;" />
		</td>
		<td align="center">
			<input type="reset" value="<?php echo $MOD_FORUM['TXT_RESET_B']; ?>" style="width: 150; margin-top: 5px;" />
		</td>
		<td align="right">
			<input type="button" value="<?php echo $MOD_FORUM['TXT_CANCEL_B']; ?>" onclick="javascript:history.back();" style="width: 150; margin-top: 5px;" />
		</td>
	</tr>
</table>

</form>