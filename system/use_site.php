<?php
$REQUEST_URI = $_SERVER['REQUEST_URI'];
$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
$HTTP_REFERER = "";
if (isset($_SERVER['HTTP_REFERER']))
	$HTTP_REFERER = $_SERVER['HTTP_REFERER'];
$SERVER_PROTOCOL = $_SERVER['SERVER_PROTOCOL'];
$QUERY_STRING = $_SERVER['QUERY_STRING'];
$dbPDO->execute("
INSERT INTO  `b32_18009385_users`.`bd_list_use_site` (
            `time_active` ,
            `request_uri` ,
            `remote_addr` ,
            `http_user_agent` ,
            `http_referer` ,
            `server_protokol` ,
            `query_string`)
VALUES ( CURRENT_TIMESTAMP ,  
'$REQUEST_URI',  
'$REMOTE_ADDR',  
'$HTTP_USER_AGENT',  
'$HTTP_REFERER', 
'$SERVER_PROTOCOL', 
'$QUERY_STRING')");
?>