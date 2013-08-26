<?php
	header("Content-type: image/png");
	require("gat.php");
	$p = new gat(file_get_contents($_GET["map"].".gat"));
	
	$x = $_GET["x"];
	$y = $_GET["y"];
	
	$im = $p->draw_map(true, 1, $x, $y);

	imagepng($im);
	imagedestroy($im);
?>