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

require_once( dirname(__FILE__)."/classes/class.validate.request.php" );
$oValidate = new c_validate_request();

$fields = array(
	'section_id'	=> array('type'	=> 'integer+', 'default'	=> NULL),
	'page_id'		=> array('type' => 'integer+', 'default'	=> NULL),
	'forumid'		=> array('type' => 'integer+', 'default'	=> NULL),
	'postid'		=> array('type' => 'integer+', 'default'	=> NULL),
	'class'			=> array('type' => 'string', 'default'	=> NULL),
	'title'			=> array('type' => 'string', 'default'	=> NULL),
	'text'			=> array('type' => 'string', 'default'	=> NULL)
);

foreach($fields as $name => $options) {
	$temp = $oValidate->get_request( $name, $options['default'], $options['type'] );
	if( NULL === $temp) die("fuck!".$name);
	${$name} = $temp;
}

require(WB_PATH . '/modules/admin.php');

/**
 *        Load Language file
 */
$lang = (dirname(__FILE__))."/languages/". LANGUAGE .".php";
require_once ( !file_exists($lang) ? (dirname(__FILE__))."/languages/EN.php" : $lang ); 

if ($class=="post") {
	$database->query( "UPDATE `".TABLE_PREFIX."mod_forum_post` set `title`='".$title."',`text`='".$text."' WHERE `postid`=".$postid );
} else {
	$database->query( "UPDATE `".TABLE_PREFIX."mod_forum_thread` set `title`='".$title."' WHERE `threadid`=".$postid );
	$database->query( "UPDATE `".TABLE_PREFIX."mod_forum_post` set `title`='".$title."',`text`='".$text."' WHERE `threadid`=".$postid." LIMIT 1" );
}

if($database->is_error()) die($database->get_error());

$admin->print_success("Forum gespeichert! [1]", ADMIN_URL . '/pages/modify.php?page_id=' . $page_id . '&section_id=' . $section_id);
return 0;
?>