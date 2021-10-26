<?php
$tnew = '';
$str = 0;
$topic=0;
if (isset($_GET['param'])) getParam(array('topic','str','tnew'),$_GET['param']);
$dbPDO->execute(
"SELECT tp.theme, 
        (SELECT count(1) FROM bd_post p WHERE p.id_theme = tp.id) cnt,
        tp.id,
        private,
        (SELECT count(1) FROM bd_theme_post p WHERE p.kod_theme = tp.id) child,
        tp.kod_user UID,
        (SELECT u.USER_NAME FROM bd_users u WHERE u.ID = tp.kod_user) USER_NAME,
        (SELECT count(1) FROM bd_post p INNER JOIN bd_post_read pr on p.id=pr.kod_post WHERE p.id_theme = tp.id and pr.kod_user=$user_id) readTopic,
        (SELECT max(p.id) FROM bd_post p WHERE p.id_theme = tp.id) pun,
        (SELECT replace(replace(left(post,50),'\'',''),'\"','') FROM bd_post p WHERE p.id = pun) pst,
        date_format(tp.timestamp,' %e-%b-%y') tcreate 
FROM bd_theme_post tp
WHERE tp.kod_theme=$topic 
 AND (tp.private=(tp.kod_user=$user_id) OR tp.private=0) 
ORDER BY pun DESC 
LIMIT $str , 50");
$forumdata = array();
while ($row  = $dbPDO->select()) {
    $forumdata []= $row;
}
echo json_encode($forumdata);