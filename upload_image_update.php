<?php
include "uploadImage.php";
 //телефон  
if (isset($_POST['id'])) {
	$ID = $_POST['id'];   
	$sql="UPDATE m_phone m
		  SET m.image=$gallery_id
		  WHERE m.ID=$ID";
	$result = $dbPDO->execute($sql);
	if ($result) {
        ErrLog("Фото для телефона установлено");
    } else {
        ErrLog("Фото not установлено $sql");
    }
}
include "db/return.php";



