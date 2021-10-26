<?php
if (!isset($_POST['folder'])) {
        return 0;
    }
$folder = trim($_POST['folder']);
if ($folder === "") {
    return 0;
}
require_once ('../common.php'); //содержит все дефайны
include_once DB;
include_once "../system/userCookies.php";
if ($dbPDO->execute("INSERT INTO bd_gallery_folder (KOD_USER, NAIMEN_FOLDER) "
        . "SELECT u.ID"
        . "     , '$folder' "
        . "FROM bd_users u "
        . "WHERE u.USER_NAME='$login'"
        . "  AND u.PASS='$password'"
        . "  AND u.SESSEION_HASH ='$hash_user'")){
    if ($dbPDO->execute("SELECT gf.ID, gf.NAIMEN_FOLDER "
            . "FROM bd_gallery_folder gf INNER JOIN "
            . "     bd_users u on gf.KOD_USER = u.ID "
            . "WHERE u.USER_NAME='$login'"
            . "  AND gf.NAIMEN_FOLDER='$folder' "
            . "  AND u.PASS='$password' "
            . "  AND u.SESSEION_HASH ='$hash_user'"))	{ 
        $row  = $dbPDO->select();
        echo $row["ID"];}}