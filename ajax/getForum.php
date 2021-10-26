<?php
$topic = $str = $user = $postID = 0;
$lim = 15;
getParam(array('topic', 'str', 'lim', 'user', 'postID'), $_GET['param']);
$dbPDO->execute(
"SELECT u.USER_NAME
    , u.ID as UID
    , u.KOD_RANK
    , u.image
    , p.POST
    , DATE_FORMAT(p.TIME_EDIT,'%e %M %Y в %k:%i:%s - ') as tedd
    , uc.USER_NAME as edit_user
    , tp.id as TID
    , tp.theme
    , tp2.theme parenttheme
    , tp.kod_theme
    , p.ID
    , current_timestamp - u.ts as LAST_ACTIVE
    , (SELECT Count(1) from bd_post qp where qp.KOD_QUOTED_POST = p.ID ) quoted
    , (SELECT Count(1) from bd_post_read pr where pr.KOD_POST = p.ID and pr.kod_user = ?) rd
    , p.KOD_QUOTED_POST
    , (SELECT us.user_name
        from bd_post bp join
             bd_users us on bp.id_user = us.id
       where bp.id = p.KOD_QUOTED_POST) quser
    , r.RANK
    , r.color
    , p.ID_USER
    , (SELECT min(pst.ID) FROM bd_post pst WHERE pst.id_theme=tp.id and pst.id>p.ID) nextPo
    , p.id_theme
    , DATE_FORMAT(p.TIME_ADD,'%e %M %Y, %k:%i:%s') as TIME_ADD
    , p.TIME_ADD as TM_ADD
    , (SELECT Count(*) FROM bd_post as bdp WHERE bdp.ID_USER = p.ID_USER) as allPost
    , (SELECT Count(*) FROM bd_post as bdp WHERE bdp.ID_USER = p.ID_USER and bdp.id_theme = p.id_theme) as currentPost
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
LIMIT $str , $lim",[$user_id,$topic,$topic,$postID,$postID,$user,$user,$user_id]);

while ($row  = $dbPDO->select()) {
    $forumdata []= $row;
}
echo json_encode($forumdata);