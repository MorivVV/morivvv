<?php 
if (!isset($_POST['imgname'])) {
    return;
}
$img_del=addslashes( trim($_POST['imgname']));
if ($img_del == "") {
    return;
}
$dbPDO->execute(
          "SELECT id, tumbs, 720p, 1080p "
        . "FROM bd_gallery "
        . "WHERE ORIG_IMAGE='$img_del'");
$row  = $dbPDO->select();
$kod_gallery = $row['id'];
$dbPDO->execute(
          "DELETE bd_gallery_access "
        . "FROM bd_gallery_access "
        . "WHERE kod_user=$user_id "
        . "  AND kod_gallery=$kod_gallery");
if($dbPDO->execute(
          "DELETE g "
        . "FROM bd_gallery g LEFT JOIN "
        . "     bd_gallery_access ga ON g.id = ga.kod_gallery "
        . "WHERE ga.kod_gallery IS NULL ")>0) {
	if (unlink("image/$img_del")) 
		ErrLog("Фото $img_del удалено!");
	$img_del = $row['tumbs'];
	if (unlink("image/tumbs/$img_del")) 
		ErrLog("Миниатюра $img_del удалена!");	
	$img_del = $row['720p'];
	if (unlink("image/720p/$img_del")) 
		ErrLog("Миниатюра 720p $img_del удалена!");		
	$img_del = $row['1080p'];
	if (unlink("image/1080p/$img_del")) 
		ErrLog("Миниатюра 1080p $img_del удалена!");	
}
