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

require('../../config.php');
require(WB_PATH . '/modules/admin.php');

if (!$admin->checkFTAN())
{
	$admin->print_header();
	$admin->print_error($MESSAGE['GENERIC_SECURITY_ACCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

include_once(WB_PATH .'/framework/module.functions.php');

/**
 *        Load Language file
 */
$lang = (dirname(__FILE__))."/languages/". LANGUAGE .".php";
require_once ( !file_exists($lang) ? (dirname(__FILE__))."/languages/EN.php" : $lang );

if (!$section_id OR !$page_id) {
	exit;
}

require_once(WB_PATH . '/modules/forum/classes/class_forumcache.php');

if(isset($_POST['job_'])) {
	
	if($_POST['job_'] == "del") {
		$postid = intval($_POST['postid']);
		
		/**
		 *	Delete a single post inside a thread
		 *
		 */
		if($_POST['class'] == "post") {
			$database->query("DELETE FROM `".TABLE_PREFIX."mod_forum_post` WHERE `postid`=".$postid);
			if($database->is_error()) die($database->get_error());
		}
		
		/**
		 *	Delete a compete thread
		 *
		 */
		if($_POST['class'] == "thread") {
			$postid = intval($_POST['postid']);

			$database->query( "DELETE FROM `".TABLE_PREFIX."mod_forum_thread` WHERE `threadid`=".$postid );
			if($database->is_error()) die($database->get_error());
			
			$database->query( "DELETE FROM `".TABLE_PREFIX."mod_forum_post` WHERE `threadid`=".$postid );
			if($database->is_error()) die($database->get_error());
		}
	}
	
	$admin->print_success("Forum gespeichert! [1]", ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id);
	return 0;
}

// Have we to update? Verify given forum id
if ($_REQUEST['forumid'])
{
	$forum = $database->query("SELECT * FROM " . TABLE_PREFIX . "mod_forum_forum WHERE forumid = '" . intval($_REQUEST['forumid']) . "' AND section_id = '$section_id' AND page_id = '$page_id'");
	if (0 === $forum->numRows())
	{
		$admin->print_error('Forum ung&uuml;ltig!', ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id);
	}

	$forum = $forum->fetchRow();

	//	Delete the Forum + Contents
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
		$temp_result = $database->query( $sql );
		if ($temp_result->numRows() == 0) {	
			$sql = "DELETE FROM ".TABLE_PREFIX."mod_forum_settings WHERE section_id = ".$section_id;
			$database->query($sql);
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
		$forums = $database->query("SELECT * FROM `" . TABLE_PREFIX . "mod_forum_forum` WHERE `section_id` = '".$section_id."' AND `page_id` = '".$page_id."' ORDER BY `displayorder` ASC");
		while ($forum = $forums->fetchRow( MYSQL_ASSOC ))
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
		UPDATE `" . TABLE_PREFIX . "mod_forum_forum`
			SET
				`title` = '" . $database->escapeString($_POST['title']) . "',
				`description` = '" . $database->escapeString($_POST['description']) . "',
				`displayorder` = '" . intval($_POST['displayorder']) . "',
				`parentid` = '" . intval($_POST['parentid']) . "',
				`readaccess` = '" . $_POST['readaccess'] . "',
				`writeaccess` = '" . $_POST['writeaccess'] . "'
		WHERE
			forumid = '".$forum['forumid']."'
	");

	if($database->is_error()) {
		$admin->print_error(
			"Error[5]: ".$database->get_error(),
			ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id
		);
	}
	$fcb = new ForumCacheBuilder($database, $section_id, $page_id);
	$fcb->build_cache(0);
	$fcb->save();
}
else
{
	// Insert new Forum!
	$database->query("
		INSERT INTO `" . TABLE_PREFIX . "mod_forum_forum`
			(`title`, `description`, `displayorder`, `parentid`, `page_id`, `section_id`, `readaccess`, `writeaccess`)
		VALUES
			('" . $_POST['title'] . "', '" . $_POST['description'] . "', '" . intval($_POST['displayorder']) . "', '" . intval($_POST['parentid']) . "', '$page_id', '$section_id', '" . $_POST['readaccess'] . "', '" . $_POST['writeaccess'] . "')
	");

	if($database->is_error()) {
		$admin->print_error(
			"Error[5.1]: ".$database->get_error(),
			ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id
		);
	}
	
	$fcb = new ForumCacheBuilder($database, $section_id, $page_id);
	$fcb->build_cache(0);
	$fcb->save();
	
	//insert settings entry if first forum on section
	$sql = "SELECT * from `".TABLE_PREFIX."mod_forum_settings` WHERE `section_id` = ".$section_id;
	$query_settings = $database->query($sql);
	if ($query_settings === false || $query_settings->numRows()  == 0) {
		$sql = "INSERT INTO ".TABLE_PREFIX."mod_forum_settings VALUES(0,".$section_id.", 5, 5, 0, 1, 1, 1, 1, 1, 30, 0, '', 'admin@admin.de', 'WEBSite Forum')";
		$database->query($sql);
	}
}

$admin->print_success("Forum gespeichert!", ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id);
?>