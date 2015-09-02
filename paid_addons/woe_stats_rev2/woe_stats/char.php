<?php
	header('Content-Type: image/png');
	$dst_x = 0;
	$dst_y = 0;
	$src_x = 70; // Crop Start X
	$src_y = 55; // Crop Srart Y
	$dst_w = 100; // Thumb width
	$dst_h = 120; // Thumb height
	$src_w = 100; // $src_x + $dst_w
	$src_h = 120; // $src_y + $dst_h
	
	$dst_image = imagecreatetruecolor($dst_w,$dst_h);
	$src_image = imagecreatefrompng("http://ro-character-simulator.ratemyserver.net/charsim.php?action=".mt_rand(0,2)."&gender={$_GET["gender"]}&viewid={$_GET["viewid"]}&hair={$_GET["hair"]}&location=512&job={$_GET["job"]}&hdye={$_GET["hdye"]}&dye={$_GET["dye"]}");
	imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
	$transp = imagecolorallocate($dst_image, 255, 0, 255);
	imagecolortransparent($dst_image,$transp);
	imagepng($dst_image);
	imagedestroy($dst_image);
?>