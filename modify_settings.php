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

// STEP 1:	Initialize
require('../../config.php');
require(WB_PATH.'/modules/admin.php');					// Include WB admin wrapper script

// include core functions of WB 2.7 to edit the optional module CSS files (frontend.css, backend.css)
@include_once(WB_PATH .'/framework/module.functions.php');

// check if module language file exists for the language set by the user (e.g. DE, EN)
if(!file_exists(WB_PATH .'/modules/forum/languages/'.LANGUAGE .'.php')) {
	// no module language file exists for the language set by the user, include default module language file EN.php
	require_once(WB_PATH .'/modules/forum/languages/EN.php');
} else {
	// a module language file exists for the language defined by the user, load it
	require_once(WB_PATH .'/modules/forum/languages/'.LANGUAGE .'.php');
}

// check if backend.css file needs to be included into the <body></body> of modify.php
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(WB_PATH ."/modules/forum/backend.css")) {
	echo '<style type="text/css">';
	include(WB_PATH .'/modules/forum/backend.css');
	echo "\n</style>\n";
}

?>

<h2><?php echo $MOD_FORUM['TXT_FORUM_B'].' '.$MOD_FORUM['TXT_SETTINGS_B']; ?></h2>
<?php
// include the button to edit the optional module CSS files
// Note: CSS styles for the button are defined in backend.css (div class="mod_moduledirectory_edit_css")
// Place this call outside of any <form></form> construct!!!
if(function_exists('edit_module_css')) {
	edit_module_css('forum');
}
?>

<?php
// Get Settings from DB
$sql  = 'SELECT * FROM '.TABLE_PREFIX.'mod_forum_settings WHERE `section_id` = '.$section_id.'';
if($query_settings = $database->query($sql)) {
	$settings = $query_settings->fetchRow(MYSQL_ASSOC);
}?>
</br></br>
<form name="edit" action="<?php echo WB_URL; ?>/modules/forum/save_settings.php" method="post" style="margin: 0;"/>

<input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
<input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
<?php echo $admin->getFTAN(); ?>

<table summary="" class="row_a" cellpadding="2" cellspacing="0" border="0" width="90%">
	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_FORUMDISPLAY_PERPAGE_B']; ?>:</td>
		<td class="forum_setting_value">
		  <input type="text" name="forumdisplay_perpage" style="width:20px;" maxlength="2" value="<?php echo $settings['FORUMDISPLAY_PERPAGE'];?>" />
		</td>
	</tr>
	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_SHOWTHREAD_PERPAGE_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="text" name="showthread_perpage" style="width:20px;" maxlength="2" value="<?php echo $settings['SHOWTHREAD_PERPAGE'];?>" />
		</td>
	</tr>
	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_PAGENAV_SIZES_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="checkbox" name="pagenav_sizes" <?php echo $settings['PAGENAV_SIZES'] ? 'checked="checked"' : '';?> />
		</td>
	</tr>
	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_DISPLAY_SUBFORUMS_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="checkbox" name="display_subforums" <?php echo $settings['DISPLAY_SUBFORUMS'] ? 'checked="checked"' : '';?> />
		</td>
	</tr>
	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_DISPLAY_SUBFORUMS_FORUMDISPLAY_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="checkbox" name="display_subforums_forumdisplay" <?php echo $settings['DISPLAY_SUBFORUMS_FORUMDISPLAY'] ? 'checked="checked"' : '';?> />
		</td>
	</tr>
	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_FORUM_USE_CAPTCHA_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="checkbox" name="forum_use_captcha" <?php echo $settings['FORUM_USE_CAPTCHA'] ? 'checked="checked"' : '';?> />
		</td>
	</tr>	
	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_USE_SMILEYS_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="checkbox" name="forum_use_smileys" <?php echo $settings['FORUM_USE_SMILEYS'] ? 'checked="checked"' : '';?> />
		</td>
	</tr>	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_HIDE_EDITOR_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="checkbox" name="forum_hide_editor" <?php echo $settings['FORUM_HIDE_EDITOR'] ? 'checked="checked"' : '';?> />
		</td>
	</tr>	
	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_ADMIN_GROUP_ID_B']; ?>:</td>
		<td class="forum_setting_value">
		  <select name="admin_group_id" size="1" >
				<?php $sql  = 'SELECT * FROM '.TABLE_PREFIX.'groups';
							$query_groups = $database->query($sql);
							while ($group = $query_groups->fetchRow(MYSQL_ASSOC)){
								if ($group['group_id'] == $settings['ADMIN_GROUP_ID'])
								  echo '<option selected value="'.$group['group_id'].'">'.$group['name'].'</option>';
								else
									echo '<option value="'.$group['group_id'].'">'.$group['name'].'</option>';
							}							
				?>
	    </select>		
		</td>
	</tr>

	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_VIEW_FORUM_SEARCH_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="checkbox" name="view_forum_search"  <?php echo $settings['VIEW_FORUM_SEARCH'] ? 'checked="checked"' : '';?> />
		</td>
	</tr>
	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_FORUM_MAX_SEARCH_HITS_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="text" name="forum_max_search_hits" style="width:20px;" maxlength="2" value="<?php echo $settings['FORUM_MAX_SEARCH_HITS'];?>" />
		</td>
	</tr>
	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_FORUM_SENDMAILS_ON_NEW_POSTS_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="checkbox" name="forum_sendmails_on_new_posts"  <?php echo $settings['FORUM_SENDMAILS_ON_NEW_POSTS'] ? 'checked="checked"' : '';?> />
		</td>
	</tr>
		<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_FORUM_ADMIN_INFO_ON_NEW_POSTS_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="text" name="forum_admin_info_on_new_posts"  maxlength="30" value="<?php echo htmlspecialchars($settings['FORUM_ADMIN_INFO_ON_NEW_POSTS']);?>" />
		</td>
	</tr>
	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_FORUM_MAIL_SENDER_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="text" name="forum_mail_sender"  maxlength="30" value="<?php echo htmlspecialchars($settings['FORUM_MAIL_SENDER']);?>" />
		</td>
	</tr>
	<tr>
		<td class="forum_setting_name"><?php echo $MOD_FORUM['TXT_FORUM_MAIL_SENDER_REALNAME_B']; ?>:</td>
		<td class="forum_setting_value">
			<input type="text" name="forum_mail_sender_realname"  maxlength="30" value="<?php echo htmlspecialchars($settings['FORUM_MAIL_SENDER_REALNAME']);?>" />
		</td>
	</tr>
</table>
<br /><br />
<table summary="" cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td align="left">
			<input name="save" type="submit" value="<?php echo $MOD_FORUM['TXT_SAVE_B']; ?>" style="width: 100px; margin-top: 5px;">
		</td>
		<td align="right">
			<input type="button" value="<?php echo $MOD_FORUM['TXT_CANCEL_B']; ?>" onclick="javascript: window.location = '<?php echo ADMIN_URL; ?>/pages/modify.php?page_id=<?php echo $page_id; ?>';" style="width: 100px; margin-top: 5px;" />
		</td>
	</tr>
</table>
</form>