<?php

// This file splits the image into randomly generated puzzle pieces

// Definte edges 
define('TOP',    0);
define('BOTTOM', 1);
define('LEFT',   2);
define('RIGHT',  3);

// Get variables
$d = $_GET['d'];
$r = $_GET['r'];
$c = $_GET['c'];
$rr = $_GET['rr'];
$cc = $_GET['cc'];

// Pad string for rounding
$g = str_pad(decbin(ord($_GET['g']) - 65), 4, '0', STR_PAD_LEFT);


if ($r == 0) {
	$g{TOP} = '0';
}
if ($r == $rr - 1) $g{BOTTOM} = '0';
if ($c == 0) $g{LEFT} = '0';
if ($c == $cc - 1) $g{RIGHT} = '0';

// For different file extionsions
$fextension = substr(strrchr($_GET['img'],'.'),1);
if ($fextension == "jpg" || $fextension == "jpeg")
	$img = imagecreatefromjpeg('puzzles/' . $_GET['img']);
if ($fextension == "gif")
	$img = imagecreatefromgif('puzzles/' . $_GET['img']);
if ($fextension == "png")
	$img = imagecreatefrompng('puzzles/' . $_GET['img']);
	
// Draw a border 
/*
$color_black = ImageColorAllocate($img, 0, 0, 0); 
drawBorder($img, $color_black, 1); 
function drawBorder(&$img, &$color, $thickness = 1) { 
	$x1 = 0; 
	$y1 = 0; 
	$x2 = ImageSX($img) - 1; 
	$y2 = ImageSY($img) - 1; 
	
	for($i = 0; $i < $thickness; $i++)  { 
		ImageRectangle($img, $x1++, $y1++, $x2--, $y2--, $color_black); 
	}
} 
*/

// Width, height, and coordinates
$w = floor(imagesx($img) / $cc);
$h = floor(imagesy($img) / $rr);


$x = $c * $w;
$y = $r * $h;

$width = 2 * $d + $w;
$height = 2 * $d + $h;

// Get browser info
$ie = (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false && strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') === false) ? true : false;

// Create gif for IE
if($ie) {
	$chop = imagecreate($width, $height);
	$trans = imagecolorallocate($chop, 255, 255, 255);
	imagecolortransparent($chop, $trans);
	imagetruecolortopalette($img, false, 250);
}

// Create png for other browsers
else {
	$chop = imagecreatetruecolor($width, $height);
	imageSaveAlpha($chop, true);
	imageAlphaBlending($chop, false);
	$trans = imagecolorallocatealpha($chop, 0, 0, 0, 127);
	imagefill($chop, 0, 0, $trans);
}

imagecopy($chop, $img, 0, 0, $x - $d, $y - $d, $width, $height);

// If there's a ball on the left
if($c == 0 || !$g[LEFT]) {
	imagefilledrectangle($chop, 0, 0, $d - 1, $height, $trans);
}
if($c != 0) {
	$rightleft = 1;
	if($g[LEFT]) {
		overlay($chop, 0, 0, $d, $height, 1, $trans);
	}
	else {
		overlay($chop, $d, 0, $d, $height, 0, $trans);
	}
}

// If there's a ball on the right
if($c == $cc - 1 || !$g[RIGHT]) {
	imagefilledrectangle($chop, $width - $d, 0, $width, $height, $trans);
}
if($c != $cc - 1) {
		$rightleft = 1;
	if($g[RIGHT]) {
		overlay($chop, $width - $d, 0, $d, $height, 1, $trans);
	}
	else {
		overlay($chop, $width - 2 * $d, 0, $d, $height, 0, $trans);
	}
}

// If there's a ball on the top
if($r == 0 || !$g[TOP]) {
	imagefilledrectangle($chop, 0, 0, $width, $d - 1, $trans);
}
if($r != 0) {
	$bottomtop = 1;
	if($g[TOP]) {
		overlay($chop, 0, 0, $width, $d, 1, $trans);
	}
	else {
		overlay($chop, 0, $d, $width, $d, 0, $trans);
	}
}

// If there's a ball on the bottom
if($r == $rr - 1 || !$g[BOTTOM]) {
	imagefilledrectangle($chop, 0, $height - $d, $width, $height, $trans);
}
if($r != $rr - 1) {
		$bottomtop = 1;
	if($g[BOTTOM]) {
		overlay($chop, 0, $height - $d, $width, $d, 1, $trans);
	}
	else {
		overlay($chop, 0, $height - 2 * $d, $width, $d, 0, $trans);
	}
}

if($ie) {
	header('Content-type: image/gif');
	imagegif($chop);
}
else {
	header('Content-type: image/jpg');
	imagepng($chop);
}

// I believe the circles are created in this function
function overlay($img, $x, $y, $w, $h, $z, $trans) {
	global $bottomtop;
	global $rightleft;
	
	$mask = imagecreatetruecolor($w, $h);
	$c[0] = imagecolorallocate($mask, 255, 0, 255);
	$c[1] = imagecolorallocate($mask, 0, 0, 127);
	imagefilledrectangle($mask, 0, 0, imagesx($mask), imagesy($mask), $c[1-$z]);
	
	// This creates the balls
	// Create another ball?
	
	
	if ($bottomtop) {
		imagefilledellipse($mask, $w / 2, $h / 2, min($w, $h) + 10, min($w, $h), $c[$z]);
		$bottomtop = 0;	
	}	
	if ($rightleft) {
		imagefilledellipse($mask, $w / 2, $h / 2, min($w, $h), min($w, $h) + 10, $c[$z]);
		$rightleft = 0;	
	}
	if (!$bottomtop && !$rightleft) {
		imagefilledellipse($mask, $w / 2, $h / 2, min($w, $h), min($w, $h), $c[$z]);
	}
	imagecolortransparent($mask, $c[1]);
	
	
	
	
	// This merges them to the square
	imagecopymerge($img, $mask, $x, $y, 0, 0, $w, $h, 100);
	
	if($z) {
		imagefill($img, $x, $y, $trans);
		imagefill($img, $x + imagesx($mask) - 1, $y + imagesy($mask) - 1, $trans);
	}
	else {
		imagefill($img, $x + $w / 2, $y + $h / 2, $trans);
	}
	imagedestroy($mask);
}

?>
