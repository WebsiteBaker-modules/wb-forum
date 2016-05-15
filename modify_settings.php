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

// STEP 1:	Initialize
require('../../config.php');
require(WB_PATH.'/modules/admin.php');					// Include WB admin wrapper script

// include core functions of WB 2.7 to edit the optional module CSS files (frontend.css, backend.css)
include_once(WB_PATH .'/framework/module.functions.php');

/**
 *        Load Language file
 */
$lang = (dirname(__FILE__))."/languages/". LANGUAGE .".php";
require_once ( !file_exists($lang) ? (dirname(__FILE__))."/languages/EN.php" : $lang );

require_once( dirname(__FILE__)."/classes/class.forum_parser.php" );
$parser = new forum_parser();

// check if backend.css file needs to be included into the <body></body> of modify.php
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(WB_PATH ."/modules/forum/backend.css")) {
	echo '<style type="text/css">';
	include(WB_PATH .'/modules/forum/backend.css');
	echo "\n</style>\n";
}

?>

<h2><?php echo $MOD_FORUM['TXT_FORUM_B'].' '.$MOD_FORUM['TXT_SETTINGS_B']; ?></h2>
<?php
// include the button to edit the optional module CSS files
// Note: CSS styles for the button are defined in backend.css (div class="mod_moduledirectory_edit_css")
// Place this call outside of any <form></form> construct!!!
if(function_exists('edit_module_css')) {
	edit_module_css('forum');
}
?>

<?php
// Get Settings from DB
$sql  = 'SELECT * FROM `'.TABLE_PREFIX.'mod_forum_settings` WHERE `section_id` = '.$section_id.'';
if($query_settings = $database->query($sql)) {
	$settings = $query_settings->fetchRow();
}

$sHTMLchecked = "checked='checked'";

$page_data = array(
	'WB_PATH'	=> WB_PATH,
	'WB_URL'	=> WB_URL,
	'ADMIN_URL'	=> ADMIN_URL,
	'page_id'	=> $page_id,
	'section_id'	=> $section_id,
	'FTAN'	=> (true === method_exists($admin, "getFTAN") ? $admin->getFTAN() : "" ),
	'MOD_FORUM.TXT_FORUMDISPLAY_PERPAGE_B' => $MOD_FORUM['TXT_FORUMDISPLAY_PERPAGE_B'],
	'settings.FORUMDISPLAY_PERPAGE'	=> $settings['FORUMDISPLAY_PERPAGE'],
	'MOD_FORUM.TXT_SHOWTHREAD_PERPAGE_B'	=> $MOD_FORUM['TXT_SHOWTHREAD_PERPAGE_B'],
	'settings.SHOWTHREAD_PERPAGE'	=> $settings['SHOWTHREAD_PERPAGE'],
	'MOD_FORUM.TXT_PAGENAV_SIZES_B'	=> $MOD_FORUM['TXT_PAGENAV_SIZES_B'],
	'settings.PAGENAV_SIZES.checked'	=> $settings['PAGENAV_SIZES'] == 1 ? $sHTMLchecked : "",
	'MOD_FORUM.TXT_DISPLAY_SUBFORUMS_B'	=> $MOD_FORUM['TXT_DISPLAY_SUBFORUMS_B'],
	'settings.DISPLAY_SUBFORUMS.checked'	=> $settings['DISPLAY_SUBFORUMS'] == 1 ? $sHTMLchecked : "",
	'MOD_FORUM.TXT_DISPLAY_SUBFORUMS_FORUMDISPLAY_B'	=> $MOD_FORUM['TXT_DISPLAY_SUBFORUMS_FORUMDISPLAY_B'],
	'settings.DISPLAY_SUBFORUMS_FORUMDISPLAY.checked'	=> $settings['DISPLAY_SUBFORUMS_FORUMDISPLAY'] == 1 ? $sHTMLchecked : "",
	'MOD_FORUM.TXT_FORUM_USE_CAPTCHA_B'	=> $MOD_FORUM['TXT_FORUM_USE_CAPTCHA_B'],
	'settings.FORUM_USE_CAPTCHA.checked'	=> $settings['FORUM_USE_CAPTCHA'] == 1 ? $sHTMLchecked : "",
	'MOD_FORUM.TXT_USE_SMILEYS_B'	=> $MOD_FORUM['TXT_USE_SMILEYS_B'],
	'settings.FORUM_USE_SMILEYS.checked'	=> $settings['FORUM_USE_SMILEYS'] == 1 ? $sHTMLchecked : "",
	'MOD_FORUM.TXT_HIDE_EDITOR_B' => $MOD_FORUM['TXT_HIDE_EDITOR_B'],
	'settings.FORUM_HIDE_EDITOR.checked'	=> $settings['FORUM_HIDE_EDITOR'] == 1 ? $sHTMLchecked : "",
	'MOD_FORUM.TXT_VIEW_FORUM_SEARCH_B'	=> $MOD_FORUM['TXT_VIEW_FORUM_SEARCH_B'],
	'settings.VIEW_FORUM_SEARCH.checked'	=> $settings['VIEW_FORUM_SEARCH'] == 1 ? $sHTMLchecked : "",
	'MOD_FORUM.TXT_FORUM_MAX_SEARCH_HITS_B'	=> $MOD_FORUM['TXT_FORUM_MAX_SEARCH_HITS_B'],
	'settings.FORUM_MAX_SEARCH_HITS'	=> $settings['FORUM_MAX_SEARCH_HITS'],
	'MOD_FORUM.TXT_FORUM_SENDMAILS_ON_NEW_POSTS_B'	=> $MOD_FORUM['TXT_FORUM_SENDMAILS_ON_NEW_POSTS_B'],
	'settings.FORUM_SENDMAILS_ON_NEW_POSTS.checked' => $settings['FORUM_SENDMAILS_ON_NEW_POSTS'] == 1 ? $sHTMLchecked : "",
	'MOD_FORUM.TXT_FORUM_ADMIN_INFO_ON_NEW_POSTS_B'	=> $MOD_FORUM['TXT_FORUM_ADMIN_INFO_ON_NEW_POSTS_B'],
	'settings.FORUM_ADMIN_INFO_ON_NEW_POSTS'	=> htmlspecialchars($settings['FORUM_ADMIN_INFO_ON_NEW_POSTS']),
	'MOD_FORUM.TXT_FORUM_MAIL_SENDER_B'	=> $MOD_FORUM['TXT_FORUM_MAIL_SENDER_B'],
	'settings.FORUM_MAIL_SENDER'	=> htmlspecialchars($settings['FORUM_MAIL_SENDER']),
	'MOD_FORUM.TXT_FORUM_MAIL_SENDER_REALNAME_B'	=> $MOD_FORUM['TXT_FORUM_MAIL_SENDER_REALNAME_B'],
	'settings.FORUM_MAIL_SENDER_REALNAME'	=> htmlspecialchars($settings['FORUM_MAIL_SENDER_REALNAME']),
	'MOD_FORUM.TXT_SAVE_B'	=> $MOD_FORUM['TXT_SAVE_B'],
	'MOD_FORUM.TXT_CANCEL_B'	=> $MOD_FORUM['TXT_CANCEL_B']
);

echo $parser->render(
	dirname(__FILE__)."/templates/settings.tmpl",
	$page_data
);	
