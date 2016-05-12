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

/*
$database->query("DELETE FROM `".TABLE_PREFIX."search` WHERE `name` = 'module' AND `value` = 'guestbook'");
$database->query("DELETE FROM `".TABLE_PREFIX."search` WHERE `extra` = 'guestbook'");
*/

$database->query("DROP TABLE " . TABLE_PREFIX . "mod_forum_forum");
$database->query("DROP TABLE " . TABLE_PREFIX . "mod_forum_cache");
$database->query("DROP TABLE " . TABLE_PREFIX . "mod_forum_post");
$database->query("DROP TABLE " . TABLE_PREFIX . "mod_forum_thread");
$database->query("DROP TABLE " . TABLE_PREFIX . "mod_forum_settings");
?>