<?php
include "db/db.php";
$newwidth = 1;
$newheight = 1;
$wp = "1080p";
if (isset($_GET["width"])){
	$newwidth = $_GET["width"];
	if (($newwidth/240)<1.1)
		$wp = "tumbs";
	elseif (($newwidth/1280)<1.1)
		$wp = "720p";
	elseif (($newwidth/1920)<1.1)
		$wp = "1080p";
}
if (isset($_GET["height"])){
	$newheight = $_GET["height"];
	if (($newheight/180)<1.1)
		$wp = "tumbs";
	elseif (($newheight/720)<1.1)
		$wp = "720p";
	elseif (($newheight/1080)<1.1)
		$wp = "1080p";
}

if (isset($_GET["img"])){
	$img = $_GET["img"];
	$dbPDO->execute("SELECT if($wp ='',orig_image,concat('$wp/',$wp)) p 
	   FROM bd_gallery
	   WHERE orig_image='$img'");
	$row  = $dbPDO->select();
	$img = $row["p"];
	}
elseif (isset($_GET["tumbs"]))
	$img = "tumbs/".$_GET["tumbs"];
else
	$img = "system/no_images.jpg";

if (!is_file("image/$img"))
	$img = "system/no_images.jpg";

list($width, $height) = getimagesize("image/$img");
switch (exif_imagetype("image/$img")) {
	case IMAGETYPE_GIF:
		$image = imagecreatefromgif("image/$img");
		break;
	case IMAGETYPE_JPEG:
		$image = imagecreatefromjpeg("image/$img");
		break;
	case IMAGETYPE_PNG:
		$image = imagecreatefrompng("image/$img");
		break;
}
if ($newwidth != 1 && $newheight == 1)
	$newheight = $height*$newwidth/$width;
if ($newheight != 1 && $newwidth == 1)
	$newwidth = $width*$newheight/$height;
if (($newwidth == 1 && $newheight == 1)||($newwidth > $width)||($newheight > $height)){
	$newwidth = $width;
	$newheight = $height;
}
$image_p = imagecreatetruecolor($newwidth, $newheight);
imagecopyresampled ($image_p, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
// выводим картинку в формате jpg в браузер
Header('Content-type: image/jpg');
Imagejpeg($image_p);
?>