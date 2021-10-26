<?php
$score = $_POST['score'];
$speed = $_POST['speed'];
$ip = $_SERVER['REMOTE_ADDR'];
include_once "mylib/mobileCheck.php";
$mob = isMobile();
if ($score>0)
	$dbPDO->execute(
	"INSERT INTO game_snake (KOD_USER
						   ,SCORE
						   ,SPEED
						   ,IP
						   ,MOBILE) 
	VALUE ((SELECT u.ID	FROM bd_users u	WHERE u.USER_NAME='$login' AND u.PASS='$password' AND u.SESSEION_HASH ='$hash_user'),$score,$speed,'$ip',$mob) ");
$dbPDO->execute(
"SELECT u.USER_NAME
		,s.SCORE
		,s.SPEED
		,s.IP
		,s.MOBILE
		,DATE_FORMAT(s.ACTIVE_TIME,'%e %M %Y, %k:%i:%s') as ACTIVE_TIME		
FROM game_snake s LEFT JOIN 
	 bd_users u	ON s.KOD_USER = u.ID
ORDER BY s.SCORE DESC, s.ACTIVE_TIME DESC
LIMIT 0, 20");
$top10="";
while ($row  = $dbPDO->select()) {	
	$pic = "";
	if ($row["MOBILE"]) $pic = "<img height=15 src=../image/system/cellular.png>";
	$top10 .= $row["USER_NAME"] . "(" . $row["IP"] . "): " . $row["SCORE"] . " очков на " . $row["SPEED"] . " скорости$pic " . $row["ACTIVE_TIME"] ."<br>";	
}
echo $top10;