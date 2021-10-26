<?php
$base = 68;
$lst = 1;
if (isset($_GET['base']))
	$base = $_GET['base'];
if (isset($_GET['list']))
	$lst = $_GET['list'];
include_once("db.php");
include_once("libs/simple_html_dom.php");
function curl_get($url, $refer ='http://www.google.com'){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53");
	curl_setopt($ch, CURLOPT_REFER, $refer);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
function res_up_img($width, $height, $uploadfile, $tumbsfile){
	$sdir = $_SERVER['DOCUMENT_ROOT'];
	$uploadfile = $sdir.$uploadfile;
	$tumbsfile = $sdir.$tumbsfile;
	list($width_orig, $height_orig) = getimagesize($uploadfile);
	if (($width_orig < $width) || ($height_orig<$height)) return false;
	$ratio_orig = $width_orig/$height_orig;

	if ($width/$height > $ratio_orig) {
	   $width = $height*$ratio_orig;
	} else {
	   $height = $width/$ratio_orig;
	}
	// ресэмплирование
	$image_p = imagecreatetruecolor($width, $height);
	
	
	switch (exif_imagetype($uploadfile)) {
		case IMAGETYPE_GIF:
			$image = imagecreatefromgif($uploadfile);
			break;
		case IMAGETYPE_JPEG:
			$image = imagecreatefromjpeg($uploadfile);
			break;
		case IMAGETYPE_PNG:
			$image = imagecreatefrompng($uploadfile);
			break;
	}
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
	imagejpeg($image_p, $tumbsfile , 80);
	return true;
}
	$dom = file_get_html("http://www.orangespb.ru/catalog/".$base."/?PAGEN_1=".$lst);
	$img = $dom->find('.item_pic a');
	foreach ($img as $i){
		echo "<a href='http://www.orangespb.ru".$i->href."'>".$i->href."</a>";
		$dom2 = file_get_html("http://www.orangespb.ru".$i->href);
		$plant_name =
		$img2 = $dom2->find('div .idp_view img',-1);
		if ($img2=="") 
			continue;
		$plant_name =$dom2->find('h1',-1);
		$plant_name = $plant_name->innertext;
		$path_parts = pathinfo($img2->{'data-zoom-image'});
		$fname = $path_parts['basename']; 
		if (!file_exists("image/upload/$fname"))
			file_put_contents("image/upload/$fname",file_get_contents("http://www.orangespb.ru".$img2->{'data-zoom-image'}));
		$file_hash_orig = hash_file("md5","image/upload/$fname").".".$path_parts['extension'];
		if (!file_exists("image/$file_hash_orig")) {
			rename("image/upload/$fname","image/$file_hash_orig");
			res_up_img(240,180, "/image/$file_hash_orig", "/image/tumbs/$file_hash_orig");
			$file_hash_tumbs = hash_file("md5","image/tumbs/$file_hash_orig").".".$path_parts['extension'];
			rename("image/tumbs/$file_hash_orig","image/tumbs/$file_hash_tumbs");
			$sql="INSERT INTO bd_gallery (kod_user, ORIG_IMAGE, tumbs, original_name) 
	              VALUES (1, '$file_hash_orig', '$file_hash_tumbs', '$plant_name')";
			$result = mysqli_query($link, $sql);
			$sql="SELECT id  
				  FROM bd_gallery 
				  WHERE ORIG_IMAGE='$file_hash_orig'";
			$result = mysqli_query($link, $sql);
			$row  = $dbPDO->select();
			$gallery_id = $row['id'];
			$sql="INSERT INTO bd_gallery_access (kod_user, kod_gallery, name_pic)  
				  VALUES (1, $gallery_id, '$plant_name')";
			$result = mysqli_query($link, $sql);
			if ($result)
				echo "Фото записанно в галерею под именем $file_hash_orig<br>";
		}
		echo "<div><img src=image/$file_hash_orig><br><b>".$img2->{'data-zoom-image'}."</b>$file_hash_orig</div>";
	}
 
 ?>