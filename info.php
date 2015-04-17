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

$module_directory = 'forum';
$module_name = 'Forum';
$module_function = 'page';
$module_version = '0.5';
$module_platform = '2.8';
$module_author = 'Julian Schuh, Bernd Michna, "Herr Rilke"';
$module_home		= 'http://www.yourdomain.tld';
$module_guid		= '44CF11ED-D38A-4B51-AF80-EE95F7C4C00D';
$module_description = 'Dieses Modul integriert ein einfaches Forum in ihre Webseite.<br/>';
$module_description .= '<pre>

WB-Forum
++++++++++++++++++++++++++++++++++++++

Version:  0.50
State: 		Beta
Modul:  	WB Forum
Author: 	Julian Schuh, Bernd Michna, Karsten Euting
WB User: 	BerndJM, herr rilke



Voraussetzungen im Template
++++++++++++++++++++++++++++++++++++++
<?php
	if(function_exists(\'register_frontend_modfiles\')) {
	register_frontend_modfiles(\'css\');
	register_frontend_modfiles(\'js\');
	}
?>

0.5 20.06.2012
++++++++++++++++++++++++++++++++++++++
+ created backend options view and according database table forum_settings
+ added option for sending email on every new post (just fill in the email address)
! made page navigation sizes work (for threads)
! fixed some notices concerning email notifications



Veränderungen
++++++++++++++++++++++++++++++++++++++
(-) bestehende Suchfunktion für die Integration in
	die SiteSearch deaktiviert, da sie bei mir
	zu Fehlern in WB 2.8 führte


Neu
+++++++++++++++++++++++++++++++++++++
(+) eigene Suchfunktion (MySQL fulltext) mit mind.
	3 Zeichen über Thread, Title und Text

(+) Die Ergebnisse der Suchfunktion verlinken so,
	dass die Pagination in längeren Threads
	unterstützt wird

(+) Die Suchfunktion läßt sich über die config.php
	zu- oder abschalten

(+) Versand von eMails bei neuen Beiträgen an
	alle anderen Beitragenden des Threads.
	Läßt sich über die config.php 	zu- oder
	abschalten

(+) Im Backend werden die bestehenden Foren
	nun auch strukturiert nach den versch.
	Ebenen dargestellt durch die Vergabe
	entsprechender CSS Klassen.

(+) Neue Meldungen und Labels in den Sprachfiles
	(warten bei Bedarf auf Übersetzung nach
	 EN und NL)

(+) Extra-Modul "Last Forum Entries" zeigt die
	letzten Beiträge an (benötigt diese
	Version 0.3), Pagination des Ziels wird
	unterstützt


 ###############################
 CSS
 neue IDs und Klassen
 ---------------------
 div #mod_last_forum_entries
 p.mod_last_forum_entries_forum
 p.mod_last_forum_entries_title
 p.mod_last_forum_entries_text
 span.mod_last_forum_entries_link

 </pre>
 ';

?>