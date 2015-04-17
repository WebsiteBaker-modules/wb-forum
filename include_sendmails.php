<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2009
 */
if(!defined('WB_PATH')) {
	exit("Cannot access this file directly");
}

/*
$res = $database->query('SELECT COUNT(*) as total FROM '.TABLE_PREFIX.'mod_forum_post WHERE threadid = ' . $thread['threadid'] );
$_count = $res->fetchRow();
$_pages = ceil($_count['total'] / SHOWTHREAD_PERPAGE);
*/
	$sql = 'SELECT DISTINCT (u.email),u.display_name
			FROM '.TABLE_PREFIX.'mod_forum_post p
				INNER JOIN '.TABLE_PREFIX.'users u ON(p.userid = u.user_id)
			WHERE threadid = ' . $thread['threadid'] .'
			  AND u.email <> "' . (isset($_SESSION['EMAIL']) ? $_SESSION['EMAIL'] : "") .'" ';
//die($sql);

$res = $database->query($sql);

$mails_ok = 0;
$mails_error = 0;
$mail_subject = WEBSITE_TITLE . ': ' . $MOD_FORUM['TXT_MAILSUBJECT_NEW_POST'];
$arr_search = array('##THREAD##', '##LINK##');
$_link = WB_URL . '/modules/forum/thread_view.php?goto='. $id['id'];
$arr_replace = array(trim($_POST['title']), $_link);

if( isset($res) AND $res->numRows() > 0)
{
	$mail_body = str_replace($arr_search, $arr_replace , $MOD_FORUM['TXT_MAILTEXT_NEW_POST'] );
	while(FORUM_SENDMAILS_ON_NEW_POSTS && $row = $res->fetchRow())
	{
		$_body = str_replace('##USERNAME##', $row['display_name'], $mail_body);
		//$wb->mail($fromaddress, $toaddress, $mail_subject, $mail_body, $fromname='')
		$versand = $wb->mail(FORUM_MAIL_SENDER, $row['email'], $mail_subject, $_body, FORUM_MAIL_SENDER_REALNAME);

		if ($versand) {
			$mails_ok ++;
		}else{
			$mails_error ++;
		}
	}
}// if $res
// notification to admin on new posts if address is given 
if (strpos(FORUM_ADMIN_INFO_ON_NEW_POSTS,'@') !== false && (!isset($_SESSION['EMAIL']) || FORUM_ADMIN_INFO_ON_NEW_POSTS != $_SESSION['EMAIL'])) {
	$mail_body = str_replace($arr_search, $arr_replace , $MOD_FORUM['TXT_MAILTEXT_NEW_POST_ADMIN'] );
	$_body = str_replace('##USERNAME##', "ADMIN", $mail_body);
	$versand = $wb->mail(FORUM_MAIL_SENDER, FORUM_ADMIN_INFO_ON_NEW_POSTS, $mail_subject, $_body, FORUM_MAIL_SENDER_REALNAME);
	if ($versand) {
		$mails_ok ++;
	}else{
		$mails_error ++;
	}	
}
if ($mails_ok || $mails_error)
	$mailing_result = '<br/>' . $mails_ok . $MOD_FORUM['TXT_MAILS_SEND_F'] . '<br/>' . $mails_error .  $MOD_FORUM['TXT_MAIL_ERRORS_F'];

//	die ($tmp);

	//die( htmlentities( nl2br($debug) ));




?>