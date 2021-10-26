<?php
if ($user_autorization){
	$ID   = addslashes( trim($_POST['ID']) );
	if (isset($_POST['image']))	{
		$IMAGE = addslashes( trim($_POST['image']) );
		$sql="UPDATE bd_users SET image='$IMAGE' WHERE ID=$ID";
	}
	else {
		$user   = addslashes( trim($_COOKIE['USER']) );
		$FAMILY   = addslashes( trim($_POST['FAMILY']) );
		$NAME   = addslashes( trim($_POST['NAME']) );
		$SURNAME   = addslashes( trim($_POST['SURNAME']) );
		$RANK   = addslashes( trim($_POST['RANK']) );
		$sql="UPDATE bd_users SET FAMILY='$FAMILY',NAME='$NAME',SURNAME='$SURNAME',KOD_RANK=$RANK WHERE ID=$ID";
	}
	$result = $dbPDO->execute($sql);
	if ($result) 
		ErrLog("Изменения внесены");
	
}
else
	ErrLog("Вы не авторизованы");
include "db/return.php";
?>
