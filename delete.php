<?php

/**
 *
 *	@module			Forum
 *	@version		0.5.9
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

//Delete all
$database->query("
	DELETE thread, forum, post
	FROM " . TABLE_PREFIX . "mod_forum_forum AS forum
	LEFT JOIN " . TABLE_PREFIX . "mod_forum_thread AS thread ON(thread.forumid = forum.forumid)
	LEFT JOIN " . TABLE_PREFIX . "mod_forum_post AS post ON(thread.threadid = post.threadid)
	WHERE forum.section_id = '$section_id'
");

//Remove Cache - we won't need it any more =)
$database->query("DELETE FROM " . TABLE_PREFIX . "mod_forum_cache WHERE section_id = '$section_id'");
?>