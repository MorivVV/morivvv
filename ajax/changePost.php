<?php
$post = $_POST['post'];

$dbPDO->execute("SELECT p.post
	FROM bd_post p, bd_users u
	WHERE p.ID=$post
	  AND u.USER_NAME='$login'
	  AND u.PASS='$password'
	  AND u.SESSEION_HASH ='$hash_user'");
if ($row  = $dbPDO->select()) {
	$pp=$row['post'];
	echo "$smiles
	<textarea class='textadd' required name='POST' id='posttext' style='width: 100%; height: 150px;'>$pp</textarea>";
	}
else
	echo $sql;