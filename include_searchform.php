<?php

/**
 *
 *	@module			Forum
 *	@version		0.5.10
 *	@authors		Julian Schuh, Bernd Michna, "Herr Rilke", Dietrich Roland Pehlke (last)
 *	@license		GNU General Public License
 *	@platform		2.8.x
 *	@requirements	PHP 5.6.x and higher
 *
 */

if (defined('VIEW_FORUM_SEARCH') AND VIEW_FORUM_SEARCH)
{
	$link = $database->get_one('SELECT `link` FROM `'.TABLE_PREFIX.'pages` WHERE `page_id` = ' . (int) PAGE_ID);
	
	$searchVal = (isset($_REQUEST['mod_forum_search']))
		? htmlentities( htmlspecialchars( stripslashes($_REQUEST['mod_forum_search'])))
		: ""
		;

	require_once( dirname(__FILE__)."/classes/class.forum_parser.php" );
	$parser = new forum_parser();
	
	$page_data = array(
		'action'	=> WB_URL . PAGES_DIRECTORY . $link . PAGE_EXTENSION,
		'searchVal'	=> $searchVal,
		'TEXT_SEARCH'	=> $TEXT["SEARCH"],
		'submit_text'	=> "go"
	
	);
	
	echo $parser->render(
		"search_form.lte",
		$page_data
	);

}
?>