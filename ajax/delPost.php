<?php

$post = $_POST['post'];
if ($dbPDO->execute("DELETE p "
                . "FROM bd_post p INNER JOIN "
                . "     bd_users u ON p.ID_USER = u.ID "
                . "WHERE p.ID=? "
                . "  AND u.USER_NAME='$login' "
                . "  AND u.PASS='$password' "
                . "  AND u.SESSEION_HASH ='$hash_user'",[$post])) {
    echo "пост удален";
}

