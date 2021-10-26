<?php 
$nick_name="";
if (isset($_POST['nick_name']))
	$nick_name = "value=".addslashes(trim($_POST['nick_name']));
?>
<form action="login.php" method="post">
	<b> Логин: </b><input required <?=$nick_name?> type="text" size="15"  name="login">
	<b> пароль: </b><input required type="password" size="10"  name="password">
	<input type="submit" value="Вход"> 
</form>
