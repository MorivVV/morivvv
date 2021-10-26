<?php 
if (!$user_autorization){	
	echo "Вы не авторизованы";
	return;}
        
if ($_POST['POST']) 
	$message   = addslashes( trim($_POST['POST']) );
$timenow = addslashes( trim($_POST['timenow']));
if (isset($_POST['user_to'])) {
    $user_to = addslashes(trim($_POST['user_to']));
    $dbPDO->execute("SELECT SESSEION_HASH, ID FROM bd_users WHERE ID = '$user_to' OR USER_NAME = '$user_to'");
    $row  = $dbPDO->select();
    $receiver = $row['SESSEION_HASH'];
    $user_to = $row['ID'];
}
if (isset($_POST['theme'])) {
	$theme = addslashes( trim($_POST['theme']));
	$dbPDO->execute(
                "INSERT INTO bd_private_message (theme, message, kod_user_to, kod_user_from) "
                . "VALUES ('$theme','$message', $user_to, $user_id)");
	$dbPDO->execute("UPDATE bd_private_message 
		  SET reading = 1
		  WHERE (reading = 0 AND
				kod_user_to=$user_id AND 
				(time_send + INTERVAL 1 MINUTE)<$timenow AND
		        kod_user_from=$user_to) OR kod_user_to=$user_id");
	}

else
{            ErrLog("Такого не может быть");

}

$localsocket = 'tcp://185.148.81.71:1234';

$sender = $_COOKIE['HASHIP'];
$user_sender = $_COOKIE['USER'];
include_once "system/smile.php";
$message = postSmile(nl2br(strip_tags($message, "<img><p>")));
// соединяемся с локальным tcp-сервером
$instance = stream_socket_client($localsocket);
// отправляем сообщение
fwrite($instance, json_encode(['sender' => $sender, 'user'=>$user_sender, 'user_to' => $user_to, 'receiver' => $receiver, 'message' => $message])  . "\n");        
        
//include "db/return.php";
