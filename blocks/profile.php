<?php
$change_foto = "";
$readonly = "readonly";
$str = 0;
$ID = $user_id;
getParam(array('ID','str'),$_GET['param']);
$dbPDO->execute("SELECT ID
	  FROM bd_users
	  WHERE ID='$ID'
	    OR user_name='$ID'");
$row  = $dbPDO->select();
$ID = $row["ID"];
$dbPDO->execute("
SELECT ID
    , user_name Никнейм
    , rank Звание
    , family Фамилия
    , name Имя
    , surname Отчество
    , ip
    , image
    , ts as 'Последняя активность'
    , timezone as 'Часовой пояс'
    , user_agent Браузер
    , email 'Почтовый ящик'
    , debug 'Режим отладки'
FROM bd_users as u INNER JOIN 
     bd_rank as r ON u.KOD_RANK=r.ID_RANK 
WHERE u.ID='$ID'
   OR u.user_name='$ID'");
$upl_img="";
if (($user_level<3) || ($user_id==$ID)) {
	$upl_img='<br>
	<input type="file" name ="imgupload"><br>
	<input type="checkbox" name ="userpic" value="2">Использовать для профиля<br>
	<input type="submit" value="загрузить фото" />';
	$readonly="";
	$change_foto='<input type="submit" value="обновить фото" />';
}
$row  = $dbPDO->select();
$site_name = $row["Никнейм"]." - профиль";
$row["Режим отладки"]=($row["Режим отладки"]==1);
$arr_count=count($row);
$arr_keys = array_keys($row);
for ($i=0; $i<$arr_count; $i++) {
	if ($arr_keys[$i] =="image")
		$img =  $row[$arr_keys[$i]];
	else
		$out[$arr_keys[$i]]= $row[$arr_keys[$i]];
}	
$smarty = new Smarty;
$smarty->assign('user_level',$user_level);
$smarty->assign('user_autorization',$user_autorization);
$smarty->assign('out',$out);
$smarty->assign('jout', json_encode($out));
$smarty->assign('img',$img);
$smarty_tpl = 'profile.tpl';
include "message.php";
