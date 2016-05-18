<?php

require_once( dirname(__FILE__)."/class.forum_parser.php");

class subway extends forum_parser
{

	protected	$guid = "E9B57628-F304-4CD3-AE6B-A56C359C2F60";
	
	protected	$author = "Dietrich Roland Pehlke (Aldus)";
	
	protected	$version = "0.1.0";
	
	public $base_path = "";
	
	public function __construct() {
		$this->base_path = WB_PATH."/modules/forum/templates/";
	}
	
	public function print_error( $sMessage="", $sLink="" ) {
		global $TEXT;
		
		$values = array(
			'BACK'	=> $TEXT['BACK'],
			'MESSAGE'	=> $sMessage,
			'LINK'	=> 	$sLink
		);
		
		return $this->render(
			$this->base_path."error.lte",
			$values
		);
	}

}

?>