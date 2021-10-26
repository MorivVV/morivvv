<?php
include_once "smile.php";
$dbPDO->execute(
"SELECT user_name, id, theme, message, times, reading "
. "FROM (SELECT u.user_name, u.id, theme, message, date_format(time_send,'%e-%b-%y %H:%i:%s') times, reading "
        . "FROM bd_private_message m LEFT JOIN "
        . "     bd_users u ON m.kod_user_from = u.id "
        . "WHERE reading = 0 AND kod_user_to=$user_id "
      . "UNION SELECT * FROM (SELECT u.user_name, u.id, theme, message, date_format(time_send,'%e-%b-%y %H:%i:%s') times, reading "
        . "FROM bd_private_message m LEFT JOIN "
        . "     bd_users u ON m.kod_user_from = u.id "
        . "WHERE reading = 1 AND kod_user_to=$user_id "
        . "  AND NOT EXISTS (SELECT 1 FROM bd_private_message WHERE reading = 0 AND kod_user_to=$user_id) ORDER BY m.id DESC LIMIT 10) mt) t "
. "ORDER BY t.id desc "
. "LIMIT 10");
$countmessage=0;
while ($row  = $dbPDO->select()) {
         
	$row['message'] = postSmile(nl2br(strip_tags($row['message'],"<img><p>")));
	$pr_msg []= $row;
        if ($row['reading'] == 0) {
            $countmessage++;
        }
}