<?php
$lim = 0;
$hdef = 180;
$folder = 0;
$dirfoto = "/image/tumbs/";
$smarty_tpl = '';
$step = 50; //количество картинок на странице
$files = array();
getParam(array('smarty_tpl','folder','lim','step','hdef'),$_GET['param']);
include "delete_img.php";
$dbPDO->execute("SELECT Count(1) cnt "
        . "FROM bd_gallery g INNER JOIN "
        . "     bd_gallery_access ga ON g.id = ga.kod_gallery "
        . "WHERE ga.KOD_USER=?",[$user_id]);
$row  = $dbPDO->select();
$cnt = $row['cnt'];
$folders[]=array("ID"=>"0","NAIMEN_FOLDER"=>"Все сразу ($cnt)", "cnt"=>$cnt);
$dbPDO->execute("SELECT IFNULL(gf.ID,1) ID"
        . ", concat(IFNULL(gf.NAIMEN_FOLDER, 'Не разобранное'), ' (',Count(1),')') NAIMEN_FOLDER "
        . ", Count(1) cnt "
        . "FROM bd_gallery_access ga LEFT JOIN "
        . "     bd_access_folder af ON ga.id = af.kod_access LEFT JOIN "
        . "     bd_gallery_folder gf ON af.kod_folder = gf.id "
        . "WHERE ga.KOD_USER=? "
        . "  AND ga.kod_gallery in (SELECT id from bd_gallery) "
        . "GROUP BY gf.ID, gf.NAIMEN_FOLDER",[$user_id]);	
while ($row  = $dbPDO->select()) {
    $folders[] = $row;
}
$dbPDO->execute("SELECT count(g.id) as cnt "
        . "FROM bd_gallery g INNER JOIN "
        . "     bd_gallery_access ga ON g.id = ga.kod_gallery "
        . "WHERE ga.kod_user= ? "
        . "  AND (?=0 OR ga.kod_folder=? OR ga.id in (SELECT kod_access FROM bd_access_folder WHERE kod_folder=?))",[$user_id,$folder,$folder,$folder]);
$row  = $dbPDO->select();
$cnt = $row['cnt'];
$dbPDO->execute("SELECT g.id"
        . ", g.orig_image"
        . ", if(ga.name_pic is Null,g.original_name,ga.name_pic) name_pic"
        . ", ga.id gaid"
        . ", g.width"
        . ", g.height"
        . ", g.width<g.height ori"
        . ", g.tumbs "
        . "FROM bd_gallery g INNER JOIN "
        . "     bd_gallery_access ga ON g.id = ga.kod_gallery "
        . "WHERE ga.kod_user= ? "
        . "  AND (?=0 OR ga.kod_folder=? OR ga.id in (SELECT kod_access FROM bd_access_folder WHERE kod_folder=?)) "
        . "ORDER BY ga.id DESC LIMIT $lim, $step",[$user_id,$folder,$folder,$folder]);
while ($row  = $dbPDO->select()){
		$files[] = $row;
} 
$smarty = new Smarty;
$smarty->assign('dirfoto',$dirfoto);
$smarty->assign('folder',$folder);
$smarty->assign('folders',$folders);
$smarty->assign('jfolders',json_encode($folders));
$smarty->assign('files',$files);
$smarty->assign('jsonfiles', json_encode($files));
$smarty->assign('lim',$lim);
$smarty->assign('hdef',$hdef );
$smarty->assign('tpl',$smarty_tpl );
$smarty->assign('cnt',$cnt);
$smarty->assign('step',$step);
if ($smarty_tpl == '') {
    $smarty_tpl = 'gallery_brick.tpl';
} else {
    $smarty_tpl = "gallery_$smarty_tpl.tpl";
}