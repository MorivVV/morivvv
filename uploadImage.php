<?php
// задание максимальной ширины и высоты
function res_up_img($width, $height){
	global $uploadfile;
	global $tumbsfile;	
	global $width_orig;
	global $height_orig;
	if (($width_orig < $width) || ($height_orig<$height)) return false;
	$ratio_orig = $width_orig/$height_orig;

	if ($width_orig<$height_orig){
		$height = $width;
		$width = $height*$ratio_orig;
	}
	else {
	if ($width/$height > $ratio_orig) {
	   $width = $height*$ratio_orig;
	} else {
	   $height = $width/$ratio_orig;
	}	}	
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

if($_FILES["imgupload"]["size"] > 1024*10*1024)
   {
     ErrLog ("Размер файла превышает 10 мегабайт");
     return;
   }
 //пользователь  
$ID = $user_id; 	
//директория загрузки оригинального файла
$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/image/'; 
// получение оригинальных размеров
list($width_orig, $height_orig) = getimagesize($_FILES['imgupload']['tmp_name']);  
//оригинальное имя файла
$path_parts = pathinfo(basename($_FILES['imgupload']['name']));
// файл
$filename = $_FILES['imgupload']['tmp_name'];
//новое имя файла
$file_hash_orig = hash_file('md5',$filename).".".$path_parts['extension'];
//место загрузки оригинального файла 
$uploadfile = $uploaddir.$file_hash_orig;
//место загрузки уменьшенного файла 
$tumbsfile = $uploaddir."tumbs/".$file_hash_orig;
$hash180 ="";
$hash720 ="";
$hash1080 ="";
if (move_uploaded_file($_FILES['imgupload']['tmp_name'], $uploadfile)) {
	
    res_up_img(240,180);	
	$tumbshash= hash_file('md5',$tumbsfile).".".$path_parts['extension'];
	if (rename($tumbsfile,$uploaddir."tumbs/".$tumbshash))
		$hash180= $tumbshash;
	
	if (res_up_img(1280,720)) {	
	$tumbshash= hash_file('md5',$tumbsfile).".".$path_parts['extension'];
	if (rename($tumbsfile,$uploaddir."720p/".$tumbshash))
		$hash720= $tumbshash;
	}
	
	if (res_up_img(1920,1080))	{
	$tumbshash= hash_file('md5',$tumbsfile).".".$path_parts['extension'];
	if (rename($tumbsfile,$uploaddir."1080p/".$tumbshash))
		$hash1080 = $tumbshash;
	}
	
	if (isset($_POST['userpic']) && ($_POST['userpic'] == 2)) {
            $result = $dbPDO->execute("UPDATE bd_users SET image='$hash180' WHERE ID=$ID");
            if ($result) {
                ErrLog("Фото установлено для профиля ");
            } else {
                ErrLog($sql);
            }
    }
    $dbPDO->execute("SELECT count(*) cnt, min(tumbs) tumbs  
	      FROM bd_gallery 
		  WHERE ORIG_IMAGE='$file_hash_orig'");
	$row  = $dbPDO->select();
	if ($row['cnt'] == 0) {
		$dbPDO->execute("INSERT INTO bd_gallery (kod_user, ORIG_IMAGE, tumbs, original_name, 720p, 1080p, width, height) 
	          VALUES ($ID, '$file_hash_orig', '$hash180', '".$path_parts['basename']."', '$hash720', '$hash1080', $width_orig, $height_orig)");
            ErrLog("Фото записанно в галерею под именем $hash180");
    }
	else		{
		$dbPDO->execute("UPDATE bd_gallery 
				SET 720p='$hash720', 
					1080p='$hash1080' 
		  WHERE ORIG_IMAGE='$file_hash_orig'");		
		}
	$dbPDO->execute("SELECT id  
	      FROM bd_gallery 
		  WHERE ORIG_IMAGE='$file_hash_orig'");
	$row  = $dbPDO->select();
	$gallery_id = $row['id'];
	//$dbPDO->execute("INSERT INTO bd_gallery_access (kod_user, kod_gallery, name_pic)  
	//      VALUES (1, $gallery_id, '".$path_parts['basename']."')");
	$dbPDO->execute("INSERT INTO bd_gallery_access (kod_user, kod_gallery, name_pic, kod_folder)  
	      VALUES ($ID, $gallery_id, '".$path_parts['basename']."', 1)");
	ErrLog ("Права доступа на фото присвоены");
} else {
    ErrLog ("Загрузка файла не удалась...");
}
if (!isset($_POST['id']))
	include "db/return.php";
