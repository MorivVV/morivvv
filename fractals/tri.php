<?php
$width = 700;
$heigth = 500;
$gran = 3;
if (isset($_GET['pnt']))
	$pnt = $_GET['pnt'];
else
	$pnt = 1000;

function Serpinskii($cnt) {
	global $points;
	global $gran;
	for ($i=3;$i<$cnt;$i++) {
		$rnd = mt_rand(0,$gran-1);
		$points []= array(($points[$rnd][0]+$points[$i][0])/2,($points[$rnd][1]+$points[$i][1])/2);
	}
}
$points = array(array(5,320),array(600,5),array(635,475));
$points []= array(mt_rand(2,$width-5),mt_rand(2,$heigth-2));

Serpinskii($pnt);

header("Content-type:image/png");

$img = imagecreate($width, $heigth);
$background_color = imagecolorallocate($img, 255, 255, 255);
$text_color = imagecolorallocate($img, 0, 14, 0);

foreach ($points as $a) {
	$x = $a[0];
	$y = $a[1];
	imageRectangle($img, $x, $y, $x+1, $y+1, $text_color);
}

imagepng($img);
imagedestroy($img);

