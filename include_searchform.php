<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2009
 */


if (defined('VIEW_FORUM_SEARCH') AND VIEW_FORUM_SEARCH)
{


	$query = $database->query('SELECT link FROM '.TABLE_PREFIX.'pages WHERE page_id = ' . (int) PAGE_ID);


	if($query->numRows() > 0)
	{
		$trail = $query->fetchRow();
		$action = WB_URL . PAGES_DIRECTORY . $trail['link'] . PAGE_EXTENSION;
		$searchVal = "";
		if(isset($_REQUEST['mod_forum_search']))
			$serachVal = htmlentities( htmlspecialchars( stripslashes($_REQUEST['mod_forum_search'])));

		echo '<div class="forum_suche" style="background:silver; border:1px solid #999; padding:2px;">';

		echo '<form action="' .  $action .'" method="get">';
		echo '<input type="hidden" name="search" value="1" />';
		echo '<label for="mod_forum_search">'.$TEXT["SEARCH"].': </label>'.
			 '<input type="text" id="mod_forum_search" name="mod_forum_search" value="'. $searchVal .'" />';
		echo '<input type="submit" value="OK" />';
		echo '</form></div>';

	}//if numRows


}//VIEW_FORUM_SEARCH
?>