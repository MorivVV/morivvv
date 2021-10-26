<?php

$kod_home = $_POST['kod_home'];
// $kod_home = 1;
// $bil_date = '2020-11-01';
require_once ('../common.php'); //содержит все дефайны
include_once DB;
include_once "../system/userCookies.php";
$dbPDO->execute("SELECT s.id ID, s.namien METER
FROM `объект_счетчики` s
WHERE s.KOD_HOME = 1",[$kod_home]);
$data = array();
while ($row  = $dbPDO->select()){
  $data[$row["ID"]]= $row;
}
echo json_encode($data);