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

if (!$section_id OR !$page_id) {
	exit;
}

require_once(WB_PATH . '/modules/forum/class_forumcache.php');

// Have we to update? Verify given forum id
if ($_REQUEST['forumid'])
{
	$forum = $database->query("SELECT * FROM " . TABLE_PREFIX . "mod_forum_forum WHERE forumid = '" . intval($_REQUEST['forumid']) . "' AND section_id = '$section_id' AND page_id = '$page_id'");
	if (!$forum->numRows())
	{
		$admin->print_error('Forum ung&uuml;ltig!', ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id);
	}

	$forum = $forum->fetchRow();

	//Delete the Forum + Contents
	if (isset($_POST['delete']))
	{		
		$toDelete = array($forum['forumid']);
		$getChildren =	$database->query("SELECT * FROM " . TABLE_PREFIX . "mod_forum_forum WHERE parentid > '0'");	
		while ($row = $getChildren->fetchRow()){
			$children[$row['parentid']][] = $row['forumid'];
		}
		if(isset($children)) {
			for($i=0;$i<count($toDelete);$i++){
				foreach($children as $parent=>$val){
					if($parent == $toDelete[$i]){
						$toDelete = array_merge($toDelete, $val);
					}
				}
			}
		}

		$delIds = implode(",",$toDelete);							
		$sql = "DELETE t, p, f 
						FROM ".TABLE_PREFIX . "mod_forum_forum as f 
							LEFT JOIN ".TABLE_PREFIX . "mod_forum_thread as t 
								ON  t.forumid=f.forumid
								LEFT JOIN ". TABLE_PREFIX . "mod_forum_post as p 
									ON t.threadid=p.threadid 								  
						WHERE f.forumid IN (".$delIds.")";
							
    $database->query($sql);   
    
	  $fcb = new ForumCacheBuilder($database, $section_id, $page_id);
		$fcb->update_cache();
		
		//delete settings if last forum in section was deleted
		$sql = "SELECT * from ".TABLE_PREFIX."mod_forum_forum WHERE section_id = ".$section_id;
	  if (mysql_num_rows(mysql_query($sql))  == 0) {
		  $sql = "DELETE FROM ".TABLE_PREFIX."mod_forum_settings WHERE section_id = ".$section_id;
			mysql_query($sql);
		}
    
		$admin->print_success("Forum gel&ouml;scht!", ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id);
		exit;
	}
}

if (!$_POST['title'])
{
	$admin->print_error('Bitte einen Titel angeben!', ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id);
}
/*
if (!$_POST['description'])
{
	$admin->print_error('Bitte eine Beschreibung angeben!', ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id);
}
*/

if (!in_array($_POST['writeaccess'], array('reg', 'unreg', 'both')))
{
	$_POST['writeaccess'] = 'reg';
}
if (!in_array($_POST['readaccess'], array('reg', 'unreg', 'both')))
{
	$_POST['readaccess'] = 'reg';
}

// Verify FOrum Parent id (Very Important!! (Tree))
if ($_POST['parentid'])
{
	//TODO Forum = Unterforum von sich selbst?
	$parentforum = $database->query("SELECT * FROM " . TABLE_PREFIX . "mod_forum_forum WHERE forumid = '" . intval($_POST['parentid']) . "'");
	if (!$parentforum->numRows())
	{
		$admin->print_error('Übergeordnetes Forum ungültig!', ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id);
	}

	$parentforum = $parentforum->fetchRow();

	if (isset($forum['forumid']) AND ($forum['forumid'] == $parentforum['forumid'] OR is_subforum_of($forum['forumid'], $parentforum['forumid'])))
	{
		$admin->print_error('Ein Forum kann nicht sich selbst untergeordnet sein!', ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id);
	}
}

function is_subforum_of($forumid, $parentid)
{
	static $iforumcache;
	global $database, $section_id, $page_id;

	if (empty($iforumcache))
	{
		$forums = $database->query("SELECT * FROM " . TABLE_PREFIX . "mod_forum_forum WHERE section_id = '$section_id' AND page_id = '$page_id' ORDER BY displayorder ASC");
		while ($forum = $forums->fetchRow())
		{
			$iforumcache["$forum[parentid]"]["$forum[forumid]"] = $forum;
		}
	}

	if (@is_array($iforumcache["$forumid"]))
	{
		foreach ($iforumcache["$forumid"] AS $curforumid => $corrforum)
		{
			if ($curforumid == $parentid OR is_subforum_of($curforumid, $parentid))
			{
				return true;
			}
		}
	}

	return false;
}



if (isset($forum['forumid']))
{
	// Update existing Forum
	$database->query("
		UPDATE " . TABLE_PREFIX . "mod_forum_forum
			SET
				title = '" . $_POST['title'] . "',
				description = '" . $_POST['description'] . "',
				displayorder = '" . intval($_POST['displayorder']) . "',
				parentid = '" . intval($_POST['parentid']) . "',
				readaccess = '" . $_POST['readaccess'] . "',
				writeaccess = '" . $_POST['writeaccess'] . "'
		WHERE
			forumid = '$forum[forumid]'
	");

	$fcb = new ForumCacheBuilder($database, $section_id, $page_id);
	$fcb->build_cache(0);
	$fcb->save();
}
else
{
	// Insert New Forum!
	$database->query("
		INSERT INTO " . TABLE_PREFIX . "mod_forum_forum
			(title, description, displayorder, parentid, page_id, section_id, readaccess, writeaccess)
		VALUES
			('" . $_POST['title'] . "', '" . $_POST['description'] . "', '" . intval($_POST['displayorder']) . "', '" . intval($_POST['parentid']) . "', '$page_id', '$section_id', '" . $_POST['readaccess'] . "', '" . $_POST['writeaccess'] . "')
	");

	$fcb = new ForumCacheBuilder($database, $section_id, $page_id);
	$fcb->build_cache(0);
	$fcb->save();
	
	//insert settings entry if first forum on section
	$sql = "SELECT * from ".TABLE_PREFIX."mod_forum_settings WHERE section_id = ".$section_id;
	$query_settings = mysql_query($sql);
	if ($query_settings === false || mysql_num_rows($query_settings)  == 0) {
		$sql = "INSERT INTO ".TABLE_PREFIX."mod_forum_settings VALUES(0,".$section_id.", 5, 5, 0, 1, 1, 1, 1, 1, 30, 0, '', 'admin@admin.de', 'WEBSite Forum')";
		mysql_query($sql);
	}
}

$admin->print_success("Forum gespeichert!", ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id);
?>