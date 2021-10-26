<?php
$width = 1000;
$heigth = 1000;
$gran = 3;
$pnt = 1000;
if (isset($_GET['pnt']))
	$pnt = $_GET['pnt'];
else
	$pnt = 1000;
function papor($pnt) {
	global $img;
	global $text_color;
	$x = 0;
	$y = 0;
	for( $i=0;$i<$pnt;$i++) {
		$r = mt_rand(0,100);
		switch ($r){
			case $r<=1:
				$a = 0; 
				$b = 0; 
				$c = 0;
				$d = 0.16;
				$e = 0;
				$f = 0;
				break;
			case $r<=80:
				$a = 0.85;
				$b = 0.04;
				$c = -0.04;
				$d = 0.85;
				$e = 0;
				$f = 1.6;
				break;
			case $r<=90:
				$a = 0.2;
				$b = -0.26;
				$c = 0.23;
				$d = 0.22;
				$e = 0;
				$f = 1.6;
				break;
			case $r<=100:
				$a = -0.15;
				$b = 0.28;
				$c = 0.26;
				$d = 0.24;
				$e = 0;
				$f = 0.44;
				break;
		}
		$x1 = ($a * $x) + ($b * $y) + $e;
		$y1 = ($c * $x) + ($d * $y) + $f;
		$x = $x1;
		$y = $y1;
		imageRectangle($img, 500+100*$x1, 100*$y1, 500+100*$x1, 100*$y1, $text_color);
	}
}

function Serpinskii($cnt) {
	global $points;
	global $gran;
	for ($i=3;$i<$cnt;$i++) {
		$rnd = mt_rand(0,$gran-1);
		$points []= array(($points[$rnd][0]+$points[$i][0])/2,($points[$rnd][1]+$points[$i][1])/2);
	}
}
//$points = array(array(5,320),array(600,5),array(635,475));
//$points []= array(mt_rand(2,$width-5),mt_rand(2,$heigth-2));

//Serpinskii(5000);

header("Content-type:image/png");

$img = imagecreate($width, $heigth);
$background_color = imagecolorallocate($img, 255, 255, 255);
$text_color = imagecolorallocate($img, 0, 14, 0);
papor($pnt);
/*
foreach ($points as $a) {
	$x = $a[0];
	$y = $a[1];
	imageRectangle($img, $x, $y, $x+1, $y+1, $text_color);
}
*/

imagepng($img);
imagedestroy($img);

