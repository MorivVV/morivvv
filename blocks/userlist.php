<?php 

getPost(array('sort' => 'SORT'
            ,'by'=>'BY'
            ,'lim1'=>'STR'));
$lim1 = (int)$lim1 * 25;
if ($sort=='null') {
   $sort   ="ASC"; 
}
if ($by=='null') {
   $by   ="1"; 
}
$dbPDO->execute("SELECT count(*) as cnt FROM bd_users");	
$row  = $dbPDO->select();
$cnt = $row['cnt']/25;	

$dbPDO->execute("SELECT * FROM bd_rank ORDER BY RANK");
$rnk="";
while ($row  = $dbPDO->select()) {
	$rnk=$rnk.'<option value="'.$row['ID_RANK'].'">'.$row['RANK'].'</option>';}
$dbPDO->execute("SELECT "
        . "u.id"
        . ", u.user_name"
        . ", u.name"
        . ", u.family"
        . ", u.surname"
        . ", r.rank"
        . " FROM bd_users as u INNER JOIN "
        . "      bd_rank as r ON u.KOD_RANK=r.ID_RANK "
        . "ORDER BY $by $sort LIMIT $lim1, 25");;
while ($row  = $dbPDO->select()) {
		$data[] = $row;
	}	

$smarty = new Smarty;
$smarty->assign('cnt',$cnt);
$smarty->assign('data', json_encode($data));
$smarty_tpl = 'userlist.tpl';
