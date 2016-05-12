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

// prevent this file from being accessed directly
if(!defined('WB_PATH'))
{
	header('Location: index.php');
	exit;
}

define('SKIP_CACHE', 1);
require_once(WB_PATH . '/modules/forum/backend.php');

if(!file_exists(WB_PATH . '/modules/forum/languages/' . LANGUAGE . '.php')) {
	require_once(WB_PATH . '/modules/forum/languages/EN.php');
} else {
	require_once(WB_PATH . '/modules/forum/languages/' . LANGUAGE . '.php');
}

?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td align="left" width="50%">
		<input type="button" value="<?php echo $MOD_FORUM['TXT_CREATE_FORUM_B']; ?>" onclick="javascript: window.location = '<?php echo WB_URL; ?>/modules/forum/addedit_forum.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>';" style="width: 100%;" />
	</td>
	<td align="left" width="50%">
		<input type="button" value="<?php echo $TEXT['SETTINGS']; ?>" onclick="javascript: window.location = '<?php echo WB_URL; ?>/modules/forum/modify_settings.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>';" style="width: 100%;" />
	</td>
</tr>
</table>

<h3><?php echo $MOD_FORUM['TXT_FORUMS_B']; ?></h3>

<ul>
<?php

$forums = $database->query("SELECT * FROM " . TABLE_PREFIX . "mod_forum_forum WHERE section_id = '$section_id' AND page_id = '$page_id' ORDER BY displayorder ASC");

if (0 == $forums->numRows())
{
	?>
	<li><?php echo $MOD_FORUM['TXT_NO_FORUMS_B']; ?></li>
	<?php
}
else
{
	$forum_array = array();
	while ($forum = $forums->fetchRow( MYSQL_ASSOC ))
	{
		$forum_array["$forum[parentid]"]["$forum[forumid]"] = $forum;
	}

	// Zuordnung Foren -> Level:
	$arrLevel = getForumLevel();

	print_forums(0);
}
?>
</ul>
<hr />