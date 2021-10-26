<?php
$name = $_GET['nick_name'];
require_once ('../common.php'); //содержит все дефайны
include_once DB;
$dbPDO->execute("SELECT * FROM bd_users WHERE USER_NAME=?",[$name]); 
$cnt = 0;
while ($row  = $dbPDO->selectNum()) {
    $cnt++;
}
if ($cnt != 0) {
    echo "<span class='user_yes'>пользователь $name существует!</span>";
} else {
    echo "<span class='user_no'>имя $name свободно!</span>";
}