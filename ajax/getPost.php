<?php
$postID = 0;

getPost(array('postID'=>'post'));
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
    , p.KOD_QUOTED_POST
    , (SELECT us.user_name
        from bd_post bp join
             bd_users us on bp.id_user = us.id
       where bp.id = p.KOD_QUOTED_POST) quser
    , r.RANK
    , (SELECT min(pst.ID) FROM bd_post pst WHERE pst.id_theme=tp.id and pst.id>p.ID) nextPo
    , r.color
    , p.ID_USER
    , p.id_theme
    , DATE_FORMAT(p.TIME_ADD,'%e %M %Y, %k:%i:%s') as TIME_ADD
    , p.TIME_ADD as TM_ADD
FROM bd_post as p INNER JOIN 
    bd_users as u ON p.ID_USER = u.ID INNER JOIN 
    bd_rank as r ON u.KOD_RANK = r.ID_RANK INNER JOIN  
    bd_theme_post tp ON p.id_theme = tp.id LEFT JOIN  
    bd_theme_post tp2 ON tp.kod_theme = tp2.id LEFT JOIN 
    bd_users as uc ON p.EDIT_USER = uc.ID 
WHERE ?=p.ID",[$postID]);

$row  = $dbPDO->select();
$row['POST'] = postSmile(nl2br(strip_tags($row['POST'],"<img><p>")));
echo json_encode($row);