<?php
$smarty_tpl = 'snake.tpl';
if (isset($_GET['param'])){
	$param = explode("-",$_GET['param']);
	if (!empty($param[0])) $smarty_tpl =$param[0].'.tpl';
}
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

$smarty = new Smarty;
$smarty->assign('height',$height);
$smarty->assign('width',$width);

?>