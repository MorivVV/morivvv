<?php
if ($user_level > 1) {
    ErrLog("Недостаточно прав доступа");
    return;
}
$smarty = new Smarty;
$ID = 1;
$dateb = "0";
getParam(array('ID','dateb'),$_GET['param']);
$dbil=[];
$dbPDO->execute("SELECT b.DATE_BIL 
           FROM (SELECT $dateb DATE_BIL FROM DUAL WHERE $dateb > 0
                UNION SELECT DISTINCT 
                      date_format(b.DATE_BIL,'%Y%m%d') as DATE_BIL 
	  FROM BILLING b INNER JOIN 
	       Объект_счетчики s ON b.KOD_METER = s.ID
	  WHERE s.KOD_HOME=$ID) b
	  ORDER BY b.DATE_BIL DESC");
while ($row  = $dbPDO->select()){
    if ($dateb == "0") {
        $dateb = $row['DATE_BIL'];
    }
    $dbil []= $row['DATE_BIL'];
} 
include "prevbil.php";
$dbPDO->execute("SELECT DISTINCT s.NAMIEN as meter
           , r.NAIMEN as res
		   , s.ID KOD_METER
           , t.CURDATE as dbil
		   , t.LAST_BIL
		   , t.DATEBIL
		   , t.DATE_RES
		   , b.BILLING
		   , r.POST
		   , r.ON_METER
		   , r.ON_PEOPLE
		--   , b.BILLING-t.LAST_BIL*r.POST*(1-r.ON_METER-r.ON_PEOPLE) as ras
		   , t.cena
		--   , round((b.BILLING-t.LAST_BIL*r.POST*(1-r.ON_METER-r.ON_PEOPLE))*t.cena,2) as summa
	  FROM Объект_счетчики s INNER JOIN
		   Объект_ресурсы r ON s.KOD_TYPE = r.ID INNER JOIN
		   Tmp t ON s.ID = t.KOD_METER LEFT JOIN
		   BILLING b ON t.KOD_METER = b.KOD_METER 
		             AND t.CURDATE = b.DATE_BIL
	  WHERE s.KOD_HOME=$ID
	    AND t.CURDATE=$dateb
	  ORDER BY s.NAMIEN, r.NAIMEN ");
$summa =0;

while ($row  = $dbPDO->select()){
		$out[] = $row;
//		$summa +=$row["summa"];
} 
$dbPDO->execute("SELECT k.ID
		   , CONCAT(k.NAIMEN,' (',ta.NAIMEN_SHORT,' ',u.NAIMEN_STREET,' ',k.HOME_NUM,'-',k.ROOM_NUM,')') Adr
	  FROM Объект_квартира k INNER JOIN 
	       Объект_улица u ON k.KOD_STREET = u.ID_STREET INNER JOIN
		   Объект_типы_адреса ta ON u.KOD_TYPE = ta.ID");	   
while ($row  = $dbPDO->select()){
		$home[$row['ID']] = $row['Adr'];
} 
$smarty->assign('user_level',$user_level);
$smarty->assign('out',$out);
$smarty->assign('outjson', json_encode($out));
$smarty->assign('home',$home);
$smarty->assign('jhome', json_encode($home));
//$smarty->assign('summa',$summa);
$smarty->assign('dbil',$dbil);
$smarty->assign('jdbil', json_encode($dbil));
$smarty->assign('dateb',$dateb);
$smarty->assign('ID',$ID);
$smarty_tpl = 'homepay.tpl';