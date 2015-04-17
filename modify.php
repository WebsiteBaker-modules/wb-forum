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

if (!$forums->numRows())
{
	?>
	<li><?php echo $MOD_FORUM['TXT_NO_FORUMS_B']; ?></li>
	<?php
}
else
{
	$forum_array = array();
	while ($forum = $forums->fetchRow())
	{
		$forum_array["$forum[parentid]"]["$forum[forumid]"] = $forum;
	}

	// Zuordnung Foren -> Level:
	$arrLevel = getForumLevel();
//	var_dump($arrLevel);

	print_forums(0);
}
?>
</ul>

<hr />