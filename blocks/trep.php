<?php

$str = $topic = $postID = $user = 0;
$print = '';
$treptheme = $allmsg = array();
include_once "system/smile.php";
include_once "theme_trep.php";

function topic_path($kodtopic) {
    global $dbPDO;
    while ($kodtopic != 0) {
        $dbPDO->execute("
SELECT  id, theme, kod_theme
FROM bd_theme_post
WHERE id = $kodtopic");
        $row  = $dbPDO->select();
        $kodtopic = $row['kod_theme'];
        $a [] = $row;
    }
    return array_reverse($a, true);
}

getParam(array('topic', 'str', 'user', 'postID', 'print', 'mod'), $_GET['param']);

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
LIMIT $str , 15",[$user_id,$topic,$topic,$postID,$postID,$user,$user,$user_id]);

while ($row  = $dbPDO->select()) {
    $cnt++;
    $topic_id = $row['TID'];
    $topic_name = $row['theme'];
    $row['POST'] = postSmile(nl2br(strip_tags($row['POST'], "<img><p>")));
    if ($row['edit_user'] <> "") {
        $row['POST'] .= "<span class='edittrepmessage'>" . $row['tedd'] . $row['edit_user'] . "</span>";
    }
    $newtrepdata[] = $row;

}

if ($cnt == 0) {
    ErrLog("Сообщения отсутствуют");
}
if ($mod=='json'){
    echo json_encode($newtrepdata);
    exit();
}
$dbPDO->execute(
"INSERT INTO bd_post_read (KOD_POST, KOD_USER)
SELECT p.id, ? 
FROM (SELECT p.id FROM bd_post p INNER JOIN 
             bd_theme_post tp on p.id_theme = tp.id 
     WHERE (?=0 OR ?=p.id_theme)
     AND (?=0 OR ?=p.ID)
     AND (?=0 OR ?=p.ID_USER)
     AND (tp.private=(tp.kod_user=?) OR tp.private=0) ORDER BY p.ID LIMIT $str , 15) p LEFT JOIN
     (SELECT kod_post FROM bd_post_read WHERE kod_user = ?) r on p.id = r.kod_post
WHERE r.kod_post is Null "
        . "AND ? > 0",[$user_id,$topic,$topic,$postID,$postID,$user,$user,$user_id,$user_id,$user_id]);
$dbPDO->execute("
SELECT count(id) allmsg  
FROM bd_post as p
WHERE ($topic=0 OR $topic=p.id_theme)
  AND ($postID=0 OR $postID=p.ID)
  AND ($user=0 OR $user=p.ID_USER)");
$row  = $dbPDO->select();
$imsg = $row['allmsg'];
$j = 0;

for ($i = 0; $i < $imsg; $i += 15) {
    $j++;
    if ($str == $i) {
        $allmsg[] = "<span>$j</span>";
    } else
    if ($topic == 0)
        $allmsg[] = '<a href="/usermessage/-' . $i . '-' . $user . '---' . $print . '">' . $j . '</a>';
    else
        $allmsg[] = '<a href="/topic/' . $topic . '-' . $i . ($print == '' ? '' : "---$print") . '">' . $j . '</a>';
}

$topic_p = topic_path($topic_id);
$site_name = $topic_name;
$smarty = new Smarty;
$smarty->assign('newtrepdata', $newtrepdata);
$smarty->assign('jsontrepdata', json_encode($newtrepdata));
$smarty->assign('jsontreptheme', json_encode($treptheme));
$smarty->assign('topic_p', $topic_p);
//$smarty->assign('topic_name', $topic_name);
$smarty->assign('user_id', $user_id);
$smarty->assign('user', $user);
$smarty->assign('treptheme', $treptheme);
$smarty->assign('u_a',$user_autorization);
$smarty->assign('topic_id', $topic_id);
$smarty->assign('cnt', $cnt);
//$smarty->assign('allmsg', $allmsg);
$smarty->assign('smiles', $smiles);
$smarty->assign('user_level', $user_level);

$smarty->assign('imsg', $imsg);
$smarty->assign('topic', $topic);
$smarty->assign('str', $str);
$smarty_tpl = "trep$print.tpl";
