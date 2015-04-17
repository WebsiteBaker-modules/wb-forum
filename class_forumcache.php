<?php
class ForumCacheBuilder {
	var $db;
	var $section_id;
	var $page_id;
	var $icache;
	var $cache;

	function ForumCacheBuilder(&$database, $section_id, $page_id) {
		$this->db =& $database;
		$this->section_id = $section_id;
		$this->page_id = $page_id;
		$this->fetch_icache();
	}

	function fetch_icache() {
		$forums = $this->db->query("SELECT * FROM " . TABLE_PREFIX . "mod_forum_forum WHERE section_id = '" . $this->section_id . "' AND page_id = '" . $this->page_id . "' ORDER BY displayorder ASC");
		while ($forum = $forums->fetchRow()) {
			foreach ($forum AS $key => $val)	{
				if (is_numeric($key) OR $key == 'lastpostinfo')	{
					unset($forum['key']);
				}
			}
			$this->icache["$forum[parentid]"]["$forum[forumid]"] = $forum;
		}
	}

	function build_cache($parentid, $readperms = 'both', $writeperms = 'both') {
		if (empty($this->icache["$parentid"])) {
			return;
		}
		foreach ($this->icache["$parentid"] AS $forumid => $forum) {
			switch ($readperms) {
				case 'reg':
					if ($forum['readaccess'] == 'both') {
						$forum['readaccess'] = 'reg';
					} elseif ($forum['readaccess'] == 'unreg') {
						$forum['readaccess'] = 'none';
					}
					break;
				case 'unreg':
					if ($forum['readaccess'] == 'both') {
						$forum['readaccess'] = 'unreg';
					} elseif ($forum['readaccess'] == 'reg') {
						$forum['readaccess'] = 'none';
					}
				break;
			}
			switch ($writeperms) {
				case 'reg':
					if ($forum['writeaccess'] == 'both') {
						$forum['writeaccess'] = 'reg';
					} elseif ($forum['writeaccess'] == 'unreg') {
						$forum['writeaccess'] = 'none';
					}
					break;
				case 'unreg':
					if ($forum['writeaccess'] == 'both') {
						$forum['writeaccess'] = 'unreg';
					} elseif ($forum['writeaccess'] == 'reg') {
						$forum['writeaccess'] = 'none';
					}
					break;
			}
			$this->cache["$forumid"] = $forum;
			$this->build_cache($forumid, $forum['readaccess'], $forum['writeaccess']);
		}
	}

	function save() {
		if (empty($this->cache)) {
			$this->db->query("REPLACE INTO ".TABLE_PREFIX."mod_forum_cache (page_id, section_id, varname, data) VALUES ('".$this->page_id."', '".$this->section_id."', 'forumcache', '')");
			return;
		}
		$this->db->query("REPLACE INTO ".TABLE_PREFIX."mod_forum_cache (page_id, section_id, varname, data) VALUES ('".$this->page_id."', '".$this->section_id."', 'forumcache', '".mysql_real_escape_string(serialize($this->cache), $this->db->db_handle)."')");
	}
	
	// build new cache after forum delete
	function update_cache(){
		$this->cache="";
		if(is_array($this->icache))
			foreach($this->icache as $parentId => $itemes)
				 $this->build_cache($parentId);
		$this->save();
	}
	
}
?>