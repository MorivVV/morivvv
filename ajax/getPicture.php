<?php
$error_log ="";

getParam(array('tumbs'), $_GET['param']);

$folders = array();
$dbPDO->execute("SELECT g.ORIG_IMAGE "
                    . ", g.id "
                    . ", g.720p "
                    . ", g.1080p "
                    . ", IFNULL(ga.name_pic,g.original_name) original_name "
                    . ", g.width "
                    . ", g.height "
                    . ", ifnull(ga.id,0) gaid "
                    . ", u.USER_NAME "
                    . ", u.ID userid "
                    . ", g.ADD "
                    . ", ga.kod_folder "
                    . ", ga.KOD_GALLERY ga "
                    . ", ga.id gaid "        
                    . "FROM bd_gallery g LEFT JOIN "
                    . "     bd_users u ON g.KOD_USER = u.ID LEFT JOIN "
                    . "     (SELECT id, KOD_GALLERY, name_pic, kod_folder FROM bd_gallery_access WHERE KOD_USER=$user_id) ga ON g.ID = ga.KOD_GALLERY "
                    . "WHERE g.tumbs like '$tumbs.%'");
$row1  = $dbPDO->select();
if ($row["kod_folder"]>0)
	$folders[0] = "-Удалить из галереи-";
$ka = $row["gaid"];
$dbPDO->execute("SELECT gf.ID, NAIMEN_FOLDER, (SELECT ' + ' FROM bd_access_folder WHERE kod_folder=gf.ID AND kod_access = $ka) used "
        . "FROM bd_gallery_folder gf "
        . "WHERE gf.KOD_USER=$user_id "
        . "ORDER BY gf.NAIMEN_FOLDER");
while ($row  = $dbPDO->select()) {
    $folders[$row["ID"]] = $row["used"].$row["NAIMEN_FOLDER"];
}

$smartyTmp = [  'img' => $row1,
                'tumbs' => $tumbs,
                'folders' => $folders,
                'error_log' => $error_log,
                'user_id' => $user_id, ];
$smarty_tpl ='ajax/getPicture.tpl';
