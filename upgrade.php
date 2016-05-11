<?php

/*

 Website Baker Project <http://www.websitebaker.org/>
 Copyright (C) 2004-2007, Ryan Djurovich

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

require(WB_PATH.'/modules/forum/info.php');

$table=$database->query("DESC ".TABLE_PREFIX."mod_forum_post search_text");
if ($table->numRows() == 0){

echo "<h2>Updating database for module: $module_name</h2>";
echo "<h3>&Auml;ndern der Datenbankstruktur f&uuml;r das Modul $module_name</h3>";

// update db schema 1
if($database->query('ALTER TABLE '.TABLE_PREFIX.'mod_forum_post ADD `search_text` MEDIUMTEXT NOT NULL AFTER `text`') )
{
	echo 'Database Field search_text added successfully<br /><br/>';
}
echo $database->get_error().'<br />';

// 2
if( $database->query('ALTER TABLE '.TABLE_PREFIX.'mod_forum_post ADD INDEX `title` ( `title` ) ') )
{
	echo 'Database index added successfully<br /><br/>';
}
echo $database->get_error().'<br />';

// 3
if( $database->query('ALTER TABLE '.TABLE_PREFIX.'mod_forum_post ADD FULLTEXT `TEST` (`title`, `search_text`)') )
{
	echo 'Database index added successfully<br /><br/>';
}
echo $database->get_error().'<br />';

//4
if( $database->query('ALTER TABLE '.TABLE_PREFIX.'mod_forum_post ADD INDEX `threadid` ( `threadid` )') )
{
	echo 'Database index added successfully<br /><br/>';
}
echo $database->get_error().'<br />';

//5
if($database->query('ALTER TABLE '.TABLE_PREFIX.'mod_forum_thread ADD INDEX `titel` ( `title` )') )
{
	echo 'Database index added successfully<br /><br/>';
}
echo $database->get_error().'<br />';

// 6
if( $database->query('ALTER TABLE '.TABLE_PREFIX.'mod_forum_thread ADD INDEX `forumid` ( `forumid` )') )
{
	echo 'Database index added successfully<br /><br/>';
}
echo $database->get_error().'<br />';

echo "<br/>";
};

if( $database->query("
CREATE TABLE IF NOT EXISTS " . TABLE_PREFIX . "mod_forum_settings (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `section_id` smallint(6) NOT NULL,
  `FORUMDISPLAY_PERPAGE` tinyint(4) NOT NULL,
  `SHOWTHREAD_PERPAGE` tinyint(4) NOT NULL,
  `PAGENAV_SIZES` tinyint(4) NOT NULL,
  `DISPLAY_SUBFORUMS` tinyint(4) NOT NULL,
  `DISPLAY_SUBFORUMS_FORUMDISPLAY` tinyint(4) NOT NULL,
  `FORUM_USE_CAPTCHA` tinyint(4) NOT NULL,
  `ADMIN_GROUP_ID` smallint(6) NOT NULL,
  `VIEW_FORUM_SEARCH` tinyint(4) NOT NULL,
  `FORUM_MAX_SEARCH_HITS` smallint(6) NOT NULL,
  `FORUM_SENDMAILS_ON_NEW_POSTS` tinyint(4) NOT NULL,
  `FORUM_ADMIN_INFO_ON_NEW_POSTS` varchar(30) COLLATE utf8_unicode_ci,
  `FORUM_MAIL_SENDER` varchar(30) COLLATE utf8_unicode_ci,
  `FORUM_MAIL_SENDER_REALNAME` varchar(30) COLLATE utf8_unicode_ci,
  `FORUM_USE_SMILEYS` tinyint(4) NOT NULL,
  `FORUM_HIDE_EDITOR` tinyint(4) NOT NULL,
  `FORUM_USERS` mediumtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
"))
{
	echo 'Database table added successfully<br /><br/>';
}
echo $database->get_error().'<br />';

$table=$database->query("DESC ".TABLE_PREFIX."mod_forum_settings FORUM_USE_SMILEYS");
if ($table->numRows() == 0){

	// add fields used from version 0.51
	if($database->query('ALTER TABLE '.TABLE_PREFIX.'mod_forum_settings ADD `FORUM_USE_SMILEYS` TINYINT(4) NOT NULL') )
	{
		echo 'Database Field FORUM_USE_SMILEYS successfully<br /><br/>';
	}
	
	if($database->query('ALTER TABLE '.TABLE_PREFIX.'mod_forum_settings ADD `FORUM_HIDE_EDITOR` TINYINT(4) NOT NULL') )
	{
		echo 'Database Field FORUM_HIDE_EDITOR successfully<br /><br/>';
	}
	
	if($database->query('ALTER TABLE '.TABLE_PREFIX.'mod_forum_settings ADD `FORUM_USERS` MEDIUMTEXT NOT NULL') )
	{
		echo 'Database Field FORUM_USERS successfully<br /><br/>';
	}
};

echo $database->get_error().'<br />';


echo "<br/><b>Module $module_name updated to version: $module_version</b><br/>";

?>