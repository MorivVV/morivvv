<?php
$post = $_POST['post'];
$text = $_POST['text'];
$dbPDO->execute("UPDATE bd_post p, bd_users u
	SET p.post = '$text'
	  , p.TIME_EDIT = current_timestamp
	  , p.EDIT_USER = u.ID
	WHERE p.ID=$post
	  AND u.USER_NAME='$login'
	  AND u.PASS='$password'
	  AND u.SESSEION_HASH ='$hash_user'");
$dbPDO->execute("SELECT p.post
	FROM bd_post p
	WHERE p.ID=$post");
$row  = $dbPDO->select();
$pp=postSmile(nl2br(strip_tags($row['post'],"<img><p>")));
echo $pp;