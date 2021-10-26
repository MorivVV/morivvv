<?php
include_once "system/smile.php";
if ($ID == $user_id) {
    $dbPDO->execute(
            "SELECT Null user_to"
            . ", m.kod_user_from id_from"
            . ", pm.id"
            . ", pm.message"
            . ", pm.kod_user_to id_to"
            . ", uf.user_name user_from"
            . ", uf.image"
            . ", reading"
            . ", date_format(time_send,'%H:%i:%s' ) time_s"
            . ", date_format(time_send,'%e-%b-%Y' ) date_s "
            . "FROM (SELECT kod_user_from, max(id) id "
            . "FROM (SELECT kod_user_from, max(id) id "
            . "FROM bd_private_message  "
            . "WHERE kod_user_to=$user_id "
            . "group by kod_user_from "
            . "UNION SELECT kod_user_to, max(id) "
            . "FROM bd_private_message  "
            . "WHERE kod_user_from=$user_id "
            . "group by kod_user_to) mg "
            . "group by kod_user_from) m INNER JOIN  "
            . "bd_private_message pm ON m.id = pm.id INNER JOIN  "
            . "bd_users uf ON m.kod_user_from=uf.id  "
            . "ORDER BY time_send DESC "
            . "LIMIT $str, 25");
} else {
    $dbPDO->execute(
            "SELECT ut.user_name user_to"
            . ", m.id"
            . ", uf.id id_from"
            . ", ut.id id_to"
            . ", uf.image"
            . ", uf.user_name user_from"
            . ", m.message"
            . ", reading"
            . ", date_format(time_send,'%H:%i:%s' ) time_s"
            . ", date_format(time_send,'%e-%b-%Y' ) date_s "
            . "FROM bd_private_message m INNER JOIN "
            . "	   bd_users ut ON m.kod_user_to=ut.id INNER JOIN "
            . "	   bd_users uf ON m.kod_user_from=uf.id "
            . "WHERE (ut.ID=$ID AND uf.ID=$user_id) OR "
            . "	  (uf.ID=$ID AND ut.ID=$user_id) "
            . "ORDER BY time_send DESC "
            . "LIMIT $str, 25");
}
$date_sms = array();
while ($row  = $dbPDO->select()){
	if (!(end($date_sms)==$row['date_s'])) 
		$date_sms []= $row['date_s'];
	$trepdata []= array('autor' => $row['user_from'],
	                    'time' => $row['time_s'],
                            'date' => $row['date_s'],
                            'avatar' => $row['image'],
                            'kod_user' => $row['id_from'],
                            'text' => postSmile(nl2br(strip_tags($row['message'],"<img><p>")))); 
	}
if (empty($trepdata)) $trepdata[]="";	
$style[] = "";
$smarty->assign('trepdata',$trepdata);
$smarty->assign('date_sms',$date_sms);
$smarty->assign('ID',$ID);
$smarty->assign('smiles',$smiles);
$smarty->assign('DT',date('YmdHis'));
$smarty->assign('next',($str+25));
$smarty->assign('prev',($str-25));
$smarty->assign('class',$style);