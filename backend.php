<?php
require_once(WB_PATH . '/modules/forum/config.php');

if (!defined('SKIP_CACHE')) {
	$forumcache = array(0);
	$cache = $database->query("SELECT * FROM " . TABLE_PREFIX . "mod_forum_cache WHERE section_id = '$section_id' AND page_id = '$page_id'");
	while ($cache_entry = $cache->fetchRow()) {
		${$cache_entry['varname']} = unserialize($cache_entry['data']);
	}
	$iforumcache = array();
	if(is_array($forumcache))
		foreach ($forumcache AS $forumid => $f) {
			$iforumcache[$f['parentid']]["$forumid"] = $forumid;
	}
}

require_once(WB_PATH . '/modules/forum/functions.php');
$user_id = (isset($_SESSION['USER_ID']) ? $_SESSION['USER_ID'] : '');
$user = $database->query("SELECT * FROM " . TABLE_PREFIX . "users WHERE user_id = '" . $user_id . "'");

if ($user) {
	$user = $user->fetchRow();
} else {
	$user = null;
}
?>