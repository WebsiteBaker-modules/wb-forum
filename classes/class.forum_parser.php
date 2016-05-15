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

class forum_parser
{

	public function render($sFilename, &$aData) {
		if(!file_exists($sFilename)) {
			die( "File not found: ".$sFilename );
		}
		$sReturnvalue = file_get_contents($sFilename);
		
		foreach($aData as $key => $value) {
			$sReturnvalue = str_replace("{{ ".$key." }}", $value, $sReturnvalue);
		}
		
		return $sReturnvalue;
	}
}
?>