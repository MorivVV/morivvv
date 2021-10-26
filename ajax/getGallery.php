<?php
$lim = 0;
$folder = 0;
getParam(array('smarty_tpl','folder','lim','step','hdef'),$_GET['param']);
$dbPDO->execute("SELECT "
    //    . "g.id"
    //    . ", g.orig_image"
        . " if(ga.name_pic is Null,g.original_name,ga.name_pic) n"
        . ", ga.id gid"
        . ", g.width w"
        . ", g.height h"
    //    . ", g.width<g.height ori"
        . ", g.tumbs t "
        . "FROM bd_gallery g INNER JOIN "
        . "     bd_gallery_access ga ON g.id = ga.kod_gallery "
        . "WHERE ga.kod_user= ? "
        . "  AND (?=0 OR ga.kod_folder=? OR ga.id in (SELECT kod_access FROM bd_access_folder WHERE kod_folder=?)) "
        . "ORDER BY ga.id DESC LIMIT $lim, $step",[$user_id,$folder,$folder,$folder]);
while ($row  = $dbPDO->select()){
    $files[] = $row;
}
echo json_encode($files);