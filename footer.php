<?php
$dbPDO->execute("SELECT u.ID "
        . ", u.USER_NAME "
        . ", r.color "
        . ", SEC_TO_TIME(UNIX_TIMESTAMP( NOW( ) ) - UNIX_TIMESTAMP( ts ) ) timeactive"
        . ", (UNIX_TIMESTAMP( NOW( ) ) - UNIX_TIMESTAMP( ts ) < 300) activenow "
        . "FROM bd_users as u LEFT JOIN "
        . "     bd_rank as r on u.kod_rank = r.id_rank "
        . "WHERE (u.ts+INTERVAL 24 HOUR )>CURRENT_TIMESTAMP ORDER BY u.ts DESC");
$user_on = $user_off =array();
while ($row  = $dbPDO->select()) {
    if ($row['activenow']) {
        $user_on[] = $row;
    } else {
        $user_off[] = $row;
    }
}
$result=null;
$dbPDO = null;
$smarty_footer = new Smarty;
$smarty_footer->assign('ydate',date('Y'));
$smarty_footer->assign('user_off',$user_off);
$smarty_footer->assign('user_on',$user_on);
$smarty_header->assign('site_name',$site_name);
$smarty_header->assign('error_log',$error_log);
if ($headerView) $smarty_header->display('header.tpl');

if (isset($smartyTmp)) {
    $smarty = new Smarty;
    foreach ($smartyTmp as $key => $value) {
        $smarty->assign($key,$value);
    }
}
if (isset($smarty)) {
    $smarty->display($smarty_tpl);
}

if ($headerView) $smarty_footer->display('footer.tpl');
 