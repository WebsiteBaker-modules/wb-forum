<?php

/**
 *
 *	@module			Forum
 *	@version		0.5.8
 *	@authors		Julian Schuh, Bernd Michna, "Herr Rilke", Dietrich Roland Pehlke (last)
 *	@license		GNU General Public License
 *	@platform		2.8.x
 *	@requirements	PHP 5.4.x and higher
 *
 */
 
require('../../config.php');
require(WB_PATH . '/modules/admin.php');

include_once(WB_PATH .'/framework/module.functions.php');

/**
 *        Load Language file
 */
$lang = (dirname(__FILE__))."/languages/". LANGUAGE .".php";
require_once ( !file_exists($lang) ? (dirname(__FILE__))."/languages/EN.php" : $lang );

if (isset($_REQUEST['forumid'])) {
	$forum = $database->query("SELECT * FROM `" . TABLE_PREFIX . "mod_forum_forum` WHERE `forumid` = '" . intval($_REQUEST['forumid']) . "' AND `section_id` = '".$section_id."' AND `page_id` = '".$page_id."'");
	if ( 0 === $forum->numRows() ) {
		$admin->print_error(
			$MOD_FORUM['TXT_NO_ACCESS_F'],
			ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'&section_id='.$section_id
		);
	}
	$forum = $forum->fetchRow();
}

require_once(WB_PATH . '/modules/forum/backend.php');

if(!function_exists("forum_str2js")) {
	function forum_str2js(&$s) {
		$a = array(
			"'"	=> "\\'",
			"\""	=> "&quot;",
			'&auml;' => "%E4",
			'&Auml;' => "%C4",
			'&ouml;' => "%F6",
			'&Ouml;' => "%D6",
			'&uuml;' => "%FC",
			'&Uuml;' => "%DC",
			'&szlig;' => "%DF",
			'&euro;' => "%u20AC",
			'$' => "%24" 
		);
		$s = str_replace( array_keys($a), array_values($a), $s);
	}
}

?>

<h2><?php echo (isset($forum['forumid']) ? $MOD_FORUM['TXT_EDIT_FORUM_B'].' - '.$forum['title'] : $MOD_FORUM['TXT_CREATE_FORUM_B']); ?></h2>

<form name="modify" action="<?php echo WB_URL; ?>/modules/forum/insertupdate_forum.php" method="post" style="margin: 0;">

<input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
<input type="hidden" name="forumid" value="<?php echo (isset($forum['forumid']) ? $forum['forumid'] : ''); ?>">

<?php echo (true === method_exists($admin, "getFTAN")) ? $admin->getFTAN() : ""; ?>

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
<?php
	
	if(!isset($forum)) return 0;
	
	$query = "SELECT * FROM `".TABLE_PREFIX."mod_forum_thread` WHERE `section_id`=".$section_id." AND `page_id`=".$page_id." AND `forumid`=".$forum['forumid']." ORDER BY `threadid` DESC";
	$result = $database->query( $query );
	if( true === $database->is_error() ) die($database->get_error());
	if(0 === $result->numRows()) return 0;
	
	$edit_link = WB_URL."/modules/forum/edit_post.php";
?>
<p></p>
<h3>List of postings</h3>
<form id="forum_<?php echo $section_id; ?>" class="forum" action="<?php echo WB_URL; ?>/modules/forum/insertupdate_forum.php" method="post">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>" />
<input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
<input type="hidden" name="forumid" value="<?php echo $forum['forumid']; ?>" />
<input type="hidden" name="postid" value="-1" />
<input type="hidden" name="class" value="-1" />
<input type="hidden" name="ts_val" value="<?php echo time(); ?>" />
<input type="hidden" name="job_" value="del" />

<ul class="forum_list_postings">

<?php

	$row_template = "
	<li class='{{ class }}'>
		<div class='forum_list_action'>
			<!--<a href='#'><img class='f_action' src='".THEME_URL."/images/modify_16.png' alt='' title='edit'></a>-->
			<a href='#' onclick=\"delete_thread('forum_".$section_id."',{{ id }},'{{ title }}','{{ class }}');\"><img class='f_action' src='".THEME_URL."/images/delete_16.png' alt='' title='delete'></a>
		</div>
		<div class='forum_list_id'>[ {{ id }} ]</div>
		<div class='forum_list_date'>{{ date }}</div>
		<div class='forum_list_title'><a href='#' onclick=\"edit_post('forum_".$section_id."',{{ id }},'{{ title }}','{{ class }}','".$edit_link."');\" >{{ title }}</a></div>
		
	</li>";
	
	
	while($temp_post = $result->fetchRow()) {
		forum_str2js( $temp_post['title'] );
		$t = array(
			'{{ class }}' => "thread",
			'{{ id }}' => $temp_post['threadid'],
			'{{ date }}' => date("Y-m-d - H:i:s",$temp_post['dateline']),
			'{{ title }}'	=> $temp_post['title']
		);
		echo str_replace( array_keys($t), array_values($t), $row_template );
		
		/**
		 *	postings zu dem faden
		 */
		$sub_query = "SELECT * FROM `".TABLE_PREFIX."mod_forum_post` WHERE `section_id`=".$section_id." AND `page_id`=".$page_id." AND `threadid`=".$temp_post['threadid']." ORDER BY `postid`";
		$sub_result = $database->query( $sub_query );
		if( true === $database->is_error() ) die($database->get_error());
		
		while($sub_post = $sub_result->fetchRow()) {
			forum_str2js($sub_post['text']);
			$t = array(
				'{{ class }}' => "post",
				'{{ id }}' => $sub_post['postid'],
				'{{ date }}' => date("Y-m-d - H:i:s",$sub_post['dateline']),
				'{{ title }}'	=> substr($sub_post['text'],0,30)
			);
			echo str_replace( array_keys($t), array_values($t), $row_template );
		
		}
	}
?>
</ul>
</form>