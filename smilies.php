<?php
$smilies = array (
	"bier" => "(B)",
	"biggrin" => ":D",
	"confused" => ":?",
	"duivel" => "=)",
	"gemeen" => "(8)",
	"hypocrite" => ":0:",
	"joint" => ":joint:",
	"mad" => ":(",
	"muur" => ":wall:",
	"pray" => ":pray:",
	"puke" => ":puke:",
	"rolleyes" => ":rolleyes:",
	"smile" => ":)",
	"tongue" => ":P",
	"wink" => ";)"
);
echo '<div>';
foreach ($smilies as $k => $v) { ?>
	<img class="forum_smilies" src="<?php echo WB_URL; ?>/modules/forum/images/smile/<?php echo $k; ?>.gif" alt="<?php echo $v; ?>" onclick="addsmiley('<?php echo $v; ?>')" border="0" />
<?php } ?>
</div>