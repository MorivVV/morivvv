<?php
$login = ($_COOKIE['USER']);
$password = trim($_COOKIE['PASS']);
$hash_user = md5($password.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);//информация о браузере, адресе и пароле пользователя