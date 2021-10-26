<?php
$gal_id = $_GET['id'];
$folder = $_GET['folder'];
$del = 0;
if (isset($_GET['del'])) {
    $del = $_GET['del'];
}
require_once ('../common.php'); //содержит все дефайны
include_once DB;
include_once "../system/userCookies.php";
if ($folder<2) {
    $folder = 1;
}
//проверяем наличие фотографии в галлерее пользователя
$dbPDO->execute("SELECT Count(*) cnt "
                    . "FROM bd_gallery_access ga INNER JOIN"
                    . "     bd_users u ON ga.KOD_USER = u.ID "
                    . "WHERE ga.KOD_GALLERY=$gal_id "
                    . "  AND u.USER_NAME='$login' "
                    . "  AND u.PASS='$password' "
                    . "  AND u.SESSEION_HASH ='$hash_user'");
$row  = $dbPDO->select();
$cnt = $row['cnt'];
if ($cnt == 0) {//если нету добавляем
    $dbPDO->execute("INSERT INTO bd_gallery_access (KOD_USER, KOD_GALLERY, name_pic, kod_folder) "
                        . "SELECT u.ID, g.ID, g.original_name, $folder "
                        . "FROM bd_gallery g, "
                        . "bd_users u "
                        . "WHERE g.ID=$gal_id"
                        . "  AND u.USER_NAME='$login'"
                        . "  AND u.PASS='$password'"
                        . "  AND u.SESSEION_HASH ='$hash_user'");
} else {
    $dbPDO->execute("UPDATE bd_users u INNER JOIN "
                        . "     bd_gallery_access ga ON u.ID = ga.KOD_USER "
                        . "SET ga.kod_folder = $folder "
                        . "WHERE ga.KOD_GALLERY=$gal_id"
                        . "  AND u.USER_NAME='$login'"
                        . "  AND u.PASS='$password'"
                        . "  AND u.SESSEION_HASH ='$hash_user'");
}
if ($del) {
    $dbPDO->execute("DELETE af "
            . "FROM bd_access_folder af INNER JOIN "
            . "     bd_gallery_access ga ON af.kod_access = ga.id INNER JOIN "
            . "     bd_users u ON ga.KOD_USER = u.ID "
            . "WHERE ga.KOD_GALLERY=$gal_id "
            . "  AND af.kod_folder=$folder"
            . "  AND u.USER_NAME='$login' "
            . "  AND u.PASS='$password' "
            . "  AND u.SESSEION_HASH ='$hash_user'");   
} else {
    $dbPDO->execute("INSERT INTO bd_access_folder (kod_access, kod_folder) "
                    . "SELECT ga.id, $folder "
                    . "FROM bd_users u INNER JOIN "
                    . "     bd_gallery_access ga ON u.ID = ga.KOD_USER "
                    . "WHERE ga.KOD_GALLERY=$gal_id "
                    . "  AND u.USER_NAME='$login' "
                    . "  AND u.PASS='$password' "
                    . "  AND u.SESSEION_HASH ='$hash_user'");
}
$dbPDO->execute("DELETE ga.* "
        . "FROM bd_users u, "
        . "	bd_gallery_access ga "
        . "WHERE ga.KOD_GALLERY=$gal_id "
        . "  AND u.ID = ga.KOD_USER "
        . "  AND ga.kod_folder=0 "
        . "  AND u.USER_NAME='$login' "
        . "  AND u.PASS='$password' "
        . "  AND u.SESSEION_HASH ='$hash_user'");
if ($del) {
    echo "";
}else {
    echo " + ";
}