<?php 
if (!$user_autorization){	
	ErrLog ("Вы не авторизованы");
	return;}
$topic = 0;
if (isset($_POST['topic'])) {
    $topic = $_POST['topic'];
}
$qpost = 'null';
if ($_POST['qpost'] != '') {
    $qpost = $_POST['qpost'];
}
$private = 0;
if (isset($_POST['private'])) {
    $private = $_POST['private'];
}
if (isset($_POST['theme'])) {
    if ($_POST['theme'] != '') {
	$theme = addslashes( trim($_POST['theme']));
	$dbPDO->execute("INSERT INTO bd_theme_post (theme,kod_theme,kod_user,private) VALUES ('$theme', $topic, $user_id, $private)");
	$dbPDO->execute("SELECT id FROM bd_theme_post WHERE kod_theme=$topic AND theme='$theme'");
	$row  = $dbPDO->select();
	$topic = $row["id"];
    }     
}
if ($_POST['POST']) {
    $post = addslashes(trim($_POST['POST']));
} else {
    ErrLog ("Такого не может быть");
    exit;
}
if (isset($_COOKIE['USER'])) {
    $user = addslashes(trim($_COOKIE['USER']));
} else {
    ErrLog ("Вы не авторизованы");
    exit;
}
if ($dbPDO->execute("INSERT INTO bd_post (POST,ID_USER,ID_THEME,KOD_QUOTED_POST) "
        . "SELECT '$post'"
        . ", u.ID, $topic, $qpost "
        . "FROM bd_users as u  "
        . "WHERE USER_NAME='$user'")) {
    ErrLog ("Коментарий добавлен в базу данных");
}
include "db/return.php";

