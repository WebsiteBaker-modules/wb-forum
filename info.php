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

$module_directory	= 'forum';
$module_name		= 'Forum';
$module_function	= 'page';
$module_version		= '0.5.7';
$module_platform	= '2.8';
$module_license		= 'GNU General Public License';
$module_author		= 'Julian Schuh, Bernd Michna, "Herr Rilke", Dietrich Roland Pehlke (last)';
$module_home		= 'http://addon.websitebaker.org/pages/en/browse-add-ons.php?type=1';
$module_guid		= '44CF11ED-D38A-4B51-AF80-EE95F7C4C00D';
$module_description	= 'Dieses Modul integriert ein einfaches Forum in ihre Webseite.<br/>';

/**
 *	0.5.7	- Bugfix for missing var in "content.php" while editing post in frontend.
 *			- Add missing constructor to class class_forumcache.php.
 *
 *	0.5.6	- Upgrade and codechanges for WebsiteBaker 2.8.3 SP3 - (4.q 2014)
 *			- Add external Changelog.
 *			- Add missing license var.
 *			- Try to set the 'module_home' link to the WebsiteBaker AddOn repository.
 *			- Remove/change deprecated mysql_xxx (PHP-)function calls.
 *
 */
?>