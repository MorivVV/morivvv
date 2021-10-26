<?php

$find_text = '';
$find_topic = '';
$find_user = '';
$sorting = 'DESC';
include_once "system/smile.php";
getParam(array('find_text', 'find_topic', 'find_user', 'sorting'), $_GET['param']);
$find_text = str_replace('_', ' ', $find_text);
$find_topic = str_replace('_', ' ', $find_topic);
$find_user = str_replace('_', ' ', $find_user);

$dbPDO->execute("SELECT `AS`.`ID`
, `AS`.`TIME_ADD`
, `AS`.`POST`
, `AS`.`ID_USER`
, `AS`.`ID_THEME`
, `AS`.`EDIT_USER`
, `AS`.`TIME_EDIT`
, `AV`.`theme`
, `AV`.`kod_theme`
, `AV`.`kod_user`
, `AV`.`timestamp`
, `AX`.`USER_NAME`
, current_timestamp - `AX`.ts as LAST_ACTIVE
, `AX`.`image`
 FROM bd_theme_post `AV`  join
	  bd_post `AS` ON `AV`.`ID` = `AS`.`ID_THEME` join
	  bd_users `AX` ON `AS`.`ID_USER` = `AX`.`ID`
WHERE '$find_text' <> ''
AND (`AS`.`POST` like '%$find_text%'
	AND `AV`.`theme` like '%$find_topic%'
	AND `AX`.`USER_NAME` like '%$find_user%'
	AND (`AV`.`private` = 0 OR `AV`.`private` = ($user_id = `AV`.`kod_user`)))
ORDER BY `AS`.`TIME_ADD` $sorting 
LIMIT 0, 20
");
$data=array();
while ($row  = $dbPDO->select()) {
    $row['POST'] = postSmile(nl2br(strip_tags($row['POST'], "<img><p>")));
    $row['POST'] = str_replace($find_text, "<span style='background:yellow'>$find_text</span>", $row['POST']);
    $data[] = $row;
}
$smarty = new Smarty;
$smarty->assign('data', $data);
$smarty->assign('find_text', $find_text);
$smarty->assign('find_topic', $find_topic);
$smarty->assign('find_user', $find_user);
$smarty_tpl = 'search.tpl';