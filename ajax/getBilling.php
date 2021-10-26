<?php

$kod_home = $_POST['kod_home'];
$bil_date = $_POST['bil_date'];
//$kod_home = 1;
// $bil_date = '2020-11-01';
require_once ('../common.php'); //содержит все дефайны
include_once DB;
include_once "../system/userCookies.php";
$dbPDO->execute("SELECT 
b.KOD_METER
, ss.KOD_TYPE
, ss.DOP
, DATE_FORMAT(b.DATE_BIL,'%d/%m/%Y') DATE_BIL
, b.BILLING
FROM объект_счетчики ss INNER JOIN
	billing b ON ss.ID = b.KOD_METER
WHERE ss.KOD_HOME = ?
and b.DATE_BIL = STR_TO_DATE(?, '%Y-%m-%d')",[$kod_home,$bil_date]);
$data = array();
while ($row  = $dbPDO->select()){
  $data []= $row;
}
echo json_encode($data);