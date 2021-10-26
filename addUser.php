<?php
if ($_POST['capcha']!=$_SESSION['captcha_keystring']) {
	ErrLog ("Введен неверный код с картинки");
}
else {
    getPost(array('UN' => 'login'
                 ,'LN'=>'family'
                 ,'FN'=>'name'
                 ,'SN'=>'2name'
                 ,'PASS'=>'password'));
	$PASS = md5($PASS);

	$dbPDO->execute(
        "INSERT INTO bd_users (USER_NAME,FAMILY,NAME,SURNAME,PASS,IP) "
      . "VALUES ('$UN', '$LN', '$FN', '$SN', '$PASS', '".$_SERVER['REMOTE_ADDR']."')");
        include "login.php";
}	
