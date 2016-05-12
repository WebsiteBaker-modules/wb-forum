### Changelog for WB Forum

### Original Text prior 0.5.5 below:

WB-Forum
++++++++++++++++++++++++++++++++++++++

Version:  0.5.4
State: 		Stable
Modul:  	WB Forum
Author: 	Julian Schuh, Bernd Michna, Karsten Euting
WB User: 	BerndJM, herr rilke



Voraussetzungen im Template
++++++++++++++++++++++++++++++++++++++
```code
<?php
	if(function_exists(\'register_frontend_modfiles\')) {
	register_frontend_modfiles(\'css\');
	register_frontend_modfiles(\'js\');
	register_frontend_modfiles(\'jquery\');
	}
?>
```
0.5.4 00.02.2014
++++++++++++++++++++++++++++++++++++++
! fixed bug with security token reportet by dermartine http://www.websitebaker.org/forum/index.php/topic,26878.msg184720.html#msg184720

0.5.3 05.01.2014
++++++++++++++++++++++++++++++++++++++
! fixed bug when used with mod_secure reported by owk444 http://www.websitebaker.org/forum/index.php/topic,15071.msg182546.html#msg182546

0.5.2 05.08.2013
++++++++++++++++++++++++++++++++++++++
+ made search field label multilingual http://www.websitebaker.org/forum/index.php/topic,15071.msg176444.html#msg176444
! fixed write access for registered users as reported by Tomno399 http://www.websitebaker.org/forum/index.php/topic,25876.msg178621.html#msg178621
! fixed salutation in admin notification as reported by Tomno399 http://www.websitebaker.org/forum/index.php/topic,25876.msg178710.html#msg178710
! disabled loading of module internal ancient jQuery version. Please activate jQuery of your wb install
+ introduced timestamp in hope of preventing robot spam by sending an stored form twice
! back button on error page leads to last page now instead of index.php

0.5.1 15.05.2013
++++++++++++++++++++++++++++++++++++++
+ notifications include name of post writer
+ added classes odd and even for forum and thread list
+ made use of smileys configureable in backend
+ option in backend for hiding post editor (instead a hide/unhide button is shown)
! some formating fixes
! use :0: instead of :0 for smiley "hypocrite" to prevent parsing times


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

(+) Die Suchfunktion läﬂt sich über die config.php
	zu- oder abschalten

(+) Versand von eMails bei neuen Beiträgen an
	alle anderen Beitragenden des Threads.
	Läﬂt sich über die config.php 	zu- oder
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
```code
 div #mod_last_forum_entries
 p.mod_last_forum_entries_forum
 p.mod_last_forum_entries_title
 p.mod_last_forum_entries_text
 span.mod_last_forum_entries_link
```