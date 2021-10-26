<?php
$smarty_tpl = 'snake';
$stage = 1;
getParam(array('smarty_tpl','stage'),$_GET['param']);

include "mylib/mobileCheck.php";
if (isMobile()) {
	$width = 13;
	$height = 16;
}
else	
{
	$width = 40;
	$height = 20;
}
if ($smarty_tpl ==='battle'){
    $dbPDO->execute("SELECT KOD_STAGE FROM battle_city ORDER BY KOD_STAGE");
    while ($row  = $dbPDO->select()){
        $level []=$row;
    }
}

    $dbPDO->execute("SELECT MAP FROM battle_city WHERE KOD_STAGE = ?",[$stage]);
    $row  = $dbPDO->select();
    $map = $row["MAP"];
    
$smarty_tpl .= '.tpl';    
$smarty = new Smarty;
$smarty->assign('height',$height);
$smarty->assign('width',$width);
$smarty->assign('map',$map);
if (isset($level)) $smarty->assign('level',$level);
