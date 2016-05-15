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

// The module description
$module_description = 'Deze module maakt een simpel forum in je Website Baker website.';

$MOD_FORUM = array(
	// Frontend
	'TXT_SUBFORUMS_F'				=> 'Subforums:',
	'TXT_THEMES_F'					=> 'onderwerpen',
	'TXT_THEME_F'					=> 'Onderwerp',
	'TXT_NO_ACCESS_F'				=> 'Geen toegang!',
	'TXT_FIRST_F'					=> 'Eerste',
	'TXT_PREVIOUS_F'				=> 'Vorige',
	'TXT_NEXT_F'					=> 'Volgende',
	'TXT_LAST_F'					=> 'Laatste',
	'TXT_FROM_F'					=> 'Door',
	'TXT_NO_TOPICS_F'				=> 'Geen onderwerpen in dit forum',
	'TXT_LAST_ARTICLE_F'			=> 'Laaste bijdrage:',
	'TXT_RESPONSES_F'				=> 'Reageer:',
	'TXT_NEW_TOPIC_F'				=> 'Nieuw onderwerp',
	'TXT_TEXT_TO_SHORT_F'			=> 'Tekst te kort!',
	'TXT_USERNAME_TO_SHORT_F'		=> 'Naam te kort!',
	'TXT_WRONG_CAPTCHA_F'			=> 'Foutieve Captcha!',
	'TXT_TOPIC_CREATED_F'			=> 'Onderwerp gemaakt!',
	'TXT_CREATE_NEW_TOPIC_F'		=> 'Maak nieuw onderwerp',
	'TXT_USERNAME_F'				=> 'Naam:',
	'TXT_VERIFICATION_F'			=> 'Verificatie:',
	'TXT_TEXT_F'					=> 'Tekst:',
	'TXT_TITLE_F'					=> 'Titel:',
	'TXT_SMILIES_F'					=> 'Smilies:',
	'TXT_SAVE_F'					=> 'Opslaan',
	'TXT_RESET_F'					=> 'Reset',
	'TXT_CANCEL_F'					=> 'Annuleren',
	'TXT_EDIT_F'					=> 'Aanpassen',
	'TXT_DELETE_F'					=> 'Verwijderen',
	'TXT_TITLE_TO_SHORT_F'			=> 'Onderwerp te kort!',
	'TXT_ARTICLE_DELETED_F'			=> 'Artikel verwijderd!',
	'TXT_ARTICLE_SAVED_F'			=> 'Artikel opgeslagen!',
	'TXT_EDIT_ARTICLE_F'			=> 'Wijzigen artikel',
	'TXT_CREATE_ANSWER_F'			=> 'Maak antwoord:',
	'TXT_QUOTE_F'					=> 'Citeer',
	'TXT_REALLY_DELETE_F'			=> 'Weet je zeker dat je dit artikel wilt verwijderen?',
	'TXT_GUEST_F'					=> 'Gast',
	'TXT_PAGES_F'					=> "Pagina's:",

	// New in 0.4.0
	'TXT_SEARCH_F'					=> 'Search',
	'TXT_HITS_F'					=> 'Hits',
	'TXT_NO_HITS_F'					=> 'There are no hits for your query',
	'TXT_NO_SEARCH_STRING_F'		=> 'Please enter a expression to search for!',
	'TXT_SEARCH_RESULT_F'			=> 'Search result',
	'TXT_READMORE_F'				=> 'read &raquo;',
	'TXT_MAILS_SEND_F'				=> ' Info-email(s) sent',
	'TXT_MAIL_ERRORS_F'				=> ' Errors while sending info-mails',
	'TXT_MAILSUBJECT_NEW_POST'		=> 'There is a new Post in the Forum',
	'TXT_MAILTEXT_NEW_POST'			=> "Hallo ##USERNAME##, \n\nYou posted in thread \"##THREAD##\" .\n" .
	"There is a new post by ##POSTER## in this thread \n\n".
	"You can read the post by following this link: \n##LINK##\n",
	'TXT_MAILTEXT_NEW_POST_ADMIN'		=> "Hello ##USERNAME##, \n\nThere is a new post by ##POSTER## in \"##THREAD##\" .\n\n" .
											"You can read the post by following this link: \n##LINK##\n",
	// Backend
	'TXT_NO_FORUMS_B'				=> 'Geen forums in deze categorie',
	'TXT_CREATE_FORUM_B'			=> 'Forum maken',
	'TXT_FORUMS_B'					=> 'Forums:',
	'TXT_FORUM_B'					=> 'Forum',
	'TXT_EDIT_FORUM_B'				=> 'Aanpassen forum',
	'TXT_SETTINGS_B'				=> 'Instellingen',
	'TXT_PERMISSIONS_B'				=> 'Rechten',
	'TXT_TITLE_B'					=> 'Titel:',
	'TXT_DESCRIPTION_B'				=> 'Omschrijving:',
	'TXT_DISPLAY_ORDER_B'			=> 'Volgorde:',
	'TXT_PARENT_FORUM_B'			=> 'Moeder Forum:',
	'TXT_DELETE_B'					=> 'Verwijderen:',
	'TXT_DELETE_FORUM_B'			=> 'Verwijder dit forum',
	'TXT_REGISTRATED_B'				=> 'Geregistreerde gebruikers',
	'TXT_NOT_REGISTRATED_B'			=> 'Anonieme gebruikers',
	'TXT_BOTH_B'					=> 'Geregistreerde en anonieme gebruikers',
	'TXT_SAVE_B'					=> 'Opslaan',
	'TXT_RESET_B'					=> 'Reset',
	'TXT_CANCEL_B'					=> 'Annuleren',
	'TXT_READ_B'					=> 'Lezen:',
	'TXT_WRITE_B'					=> 'Schrijven:',
	'TXT_FORUMDISPLAY_PERPAGE_B'	=> 'Number of threads per page?',
	'TXT_SHOWTHREAD_PERPAGE_B'		=> 'Number of posts per page?',
	'TXT_PAGENAV_SIZES_B'			=> 'Use different font sizes for page navigation?',
	'TXT_DISPLAY_SUBFORUMS_B'		=> 'Show sub threads on start page?',
	'TXT_DISPLAY_SUBFORUMS_FORUMDISPLAY_B'	=> 'Show sub threads in thread view?',
	'TXT_FORUM_USE_CAPTCHA_B'		=> 'Use captchas for guests?',
	'TXT_ADMIN_GROUP_ID_B'			=> 'Admin group (has permission to edit posts)?',
	'TXT_VIEW_FORUM_SEARCH_B'		=> 'Show search field?',
	'TXT_FORUM_MAX_SEARCH_HITS_B'	=> 'Maximum search hits to show?',
	'TXT_FORUM_SENDMAILS_ON_NEW_POSTS_B'	=> 'Send email notifiaction on new post in thread?',
	'TXT_FORUM_ADMIN_INFO_ON_NEW_POSTS_B'	=> 'Inform this address on every new post?',
	'TXT_FORUM_MAIL_SENDER_B'		=> 'Email sender address?',
	'TXT_FORUM_MAIL_SENDER_REALNAME_B'	=> 'Email sender name?',
	'TXT_USE_SMILEYS_B'				=> 'Use Smileys?',
	'TXT_HIDE_EDITOR_B'				=> 'Hide Editor?'
);
?>