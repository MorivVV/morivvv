<?php
$kodid =$_GET['id'];
$name = $_GET['new_name'];
if ($kodid == "" && $kodid == "0") {
    return 0;
} 
include "db/db.php";
$dbPDO->execute(
"UPDATE bd_gallery_access 
       SET name_pic='$name'
	   WHERE id=$kodid");
?>