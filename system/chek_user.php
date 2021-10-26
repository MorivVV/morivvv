<?php
$user_autorization = false;
$user_level = 4; //пользователь по умолчанию
$user_id = 0; //пользователь по умолчанию
$local_time_zone = "+04:00"; //временная зона по умолчанию для Самары
$debug_on = false;
if (isset($_COOKIE['HASHIP'])){
	include_once "userCookies.php";
	$dbPDO->execute(
                  "SELECT * "
                . "FROM bd_users "
                . "WHERE USER_NAME='$login' "
                . "  AND PASS='$password' "
                . "  AND SESSEION_HASH ='$hash_user'");
	setcookie("USER" , "", time() - 3600, "/");
	setcookie("PASS" , "", time() - 3600, "/");
	setcookie("HASHIP" , "", time() - 3600, "/");
        setcookie("DEBUGON" , "", time() - 3600, "/");
	if ($row  = $dbPDO->select()){
		$user_autorization = true;
		$profile_image=$row['image'];
		$user_level = $row['KOD_RANK'];
		$user_id = $row['ID'];
		$local_time_zone = $row['timezone'];
                $debug_on = $row['debug'];
		$dbPDO->execute(
                          "UPDATE bd_users "
                        . "SET ENTER_TIME = CURRENT_TIMESTAMP "
                        . "WHERE USER_NAME='$login' "
                        . "  AND PASS='$password' "
                        . "  AND SESSEION_HASH ='$hash_user'");
		setcookie("USER" , $row['USER_NAME'], time()+36000, "/");//продлеваем сессию на час
		setcookie("PASS" , $password, time()+36000, "/");
		setcookie("HASHIP", $hash_user, time()+36000, "/");//установка куки с информацией о браузере, адресе и пароле пользователя
                setcookie("DEBUGON", $debug_on, time()+36000, "/");//установка куки с информацией о браузере, адресе и пароле пользователя
	}
}
$dbPDO->execute("SET time_zone = '$local_time_zone'");
