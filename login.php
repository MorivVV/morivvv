<?php
getPost(array('login' => 'login'
            ,'password'=>'password'));
$password = md5($password);
$dbPDO->execute("SELECT * FROM bd_users as u  WHERE USER_NAME='$login' AND PASS='$password'");
if ($row  = $dbPDO->select()) {
    setcookie("USER", $row['USER_NAME'], time() + 36000, "/");
    setcookie("PASS", $password, time() + 36000, "/");
    $hash_user = md5($password . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']); //информация о пароле, адресе и браузере пользователя зашифрованная в хеш
    if (setcookie("HASHIP", $hash_user, time() + 36000, "/")) {//установка куки с информацией о браузере, адресе и пароле пользователя
        ErrLog ("<br>");
    }
    $dbPDO->execute(
            "INSERT INTO bd_active_user (KOD_USER, IP, USER_AGENT ) "
            . "SELECT ID"
            . "     , '" . $_SERVER['REMOTE_ADDR'] . "'"
            . "     , '" . $_SERVER['HTTP_USER_AGENT'] . "' "
            . "FROM bd_users "
            . "WHERE USER_NAME='$login' "
            . "  AND PASS='$password'");
    $dbPDO->execute(
            "UPDATE bd_users "
            . "SET ENTER_TIME = CURRENT_TIMESTAMP"
            . "  , SESSEION_HASH ='$hash_user'"
            . "  , USER_AGENT='" . $_SERVER['HTTP_USER_AGENT'] . "' "
            . "WHERE USER_NAME='$login' "
            . "  AND PASS='$password'");
    ErrLog("Вход выполнен");
    include "db/return.php";
}
else {
    ErrLog("Авторизация не удалась: связка пользователь/пароль не найдена");
}

