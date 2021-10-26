<?php
$topic = $str = $user = $postID = 0;
$lim = 15;
getParam(array('topic', 'str', 'lim', 'user', 'postID'), $_GET['param']);
$dbPDO->execute(
"SELECT p.ID
, DATE_FORMAT(p.TIME_ADD,'%e %M %Y, %k:%i:%s') as TIME_ADD
, p.POST
, p.ID_USER
, p.ID_THEME
, p.EDIT_USER
, DATE_FORMAT(p.TIME_EDIT,'%e %M %Y, %k:%i:%s') as TIME_EDIT
, p.PRIORITET
, p.KOD_QUOTED_POST 
FROM bd_post as p INNER JOIN 
    bd_users as u ON p.ID_USER = u.ID INNER JOIN 
    bd_rank as r ON u.KOD_RANK = r.ID_RANK INNER JOIN  
    bd_theme_post tp ON p.id_theme = tp.id LEFT JOIN  
    bd_theme_post tp2 ON tp.kod_theme = tp2.id LEFT JOIN 
    bd_users as uc ON p.EDIT_USER = uc.ID 
WHERE (?=0 OR ?=p.id_theme)
  AND (?=0 OR ?=p.ID)
  AND (?=0 OR ?=p.ID_USER)
  AND (tp.private=(tp.kod_user=?) OR tp.private=0)
ORDER BY ID
LIMIT $str , $lim",[$topic,$topic,$postID,$postID,$user,$user,$user_id]);
$in = '';
while ($row  = $dbPDO->select()) {
    $arrdata []= $row;
    if ($in <> '') {
        $in .= ', ';
    }
    $in .= $row['ID_USER'];
    if ($row['EDIT_USER']){
        $in .= ', ' . $row['EDIT_USER'];
    }
}
$forumdata['post'] = $arrdata;
$arrdata = array();
$dbPDO->execute(
    "SELECT DISTINCT 
    u.USER_NAME
    , u.ID
    , u.KOD_RANK
    , u.image
    FROM bd_users u
    WHERE u.ID in ($in)
    ORDER BY u.ID" ,[]);
    
    while ($row  = $dbPDO->select()) {
        $arrdata[$row['ID']]= $row;
    }
    $forumdata['user'] = $arrdata;

echo json_encode($forumdata);