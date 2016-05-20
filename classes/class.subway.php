<?php

/**
 *	We are not using LEPTON-CMS here.
 *
 */
 

require_once( dirname(__FILE__)."/class.forum_parser.php");

class subway extends forum_parser
{

	protected	$guid = "E9B57628-F304-4CD3-AE6B-A56C359C2F60";
	
	protected	$author = "Dietrich Roland Pehlke (Aldus)";
	
	protected	$version = "0.1.0";
	
	public $db = NULL;
	
	public function __construct() {
	
		parent::__construct();
		
		$this->db = new database2();
	}
	
	public function print_error( $sMessage="", $sLink="" ) {
		global $TEXT;
		
		$values = array(
			'BACK'	=> $TEXT['BACK'],
			'MESSAGE'	=> $sMessage,
			'LINK'	=> 	$sLink
		);
		
		return $this->render(
			"error.lte",
			$values
		);
	}
	
	public function register(&$aLookUp, $aKey="", $aDefault=NULL) {
		if(!isset($aLookUp[ $aKey ])) $aLookUp[ $aKey ] = $aDefault;
	}
	
	public function display($any) {
		$s = "<pre>";
		ob_start();
			print_r($any);
		$s .= ob_get_clean();
		$s .= "</pre>";
		return $s;
	}
	
	public function get_pageinfo($aID) {
		$r = $this->db->query("SELECT * FROM `".TABLE_PREFIX."pages` WHERE `page_id`=".$aID);
		
		if($r) {
			return $r->fetchRow( MYSQL_ASSOC ); // WB_URL.PAGES_DIRECTORY.$r.PAGE_EXTENSION;
		}
	}
}

class database2 extends database
{

	public function get_all( $sql="", &$storrage=array() )
	{
		$result = $this->query( $sql );
		while($ref = $result->fetchRow( MYSQL_ASSOC )) {
			$storrage[] = $ref;
		}
	}
	
}
?>