<?php
$meter = $_GET['meter'];
$billing = $_GET['billing'];
$date = $_GET['date'];

foreach ($_POST as $key => $value) {
  ${$key} = $value;
}

require_once ('../common.php'); //содержит все дефайны
include_once DB;

$dbPDO->execute("SELECT Count(KOD_METER) cnt "
        . "FROM BILLING "
        . "WHERE KOD_METER=? AND DATE_BIL=?",[$meter,$date]);
$row  = $dbPDO->select();
if ($row["cnt"]==0)
	$dbPDO->execute("INSERT INTO BILLING (KOD_METER, DATE_BIL, BILLING)
	VALUES (?,?,?)",[$meter,$date,$billing]);
else
    $dbPDO->execute("UPDATE BILLING "
            . "SET BILLING = ? "
            . "WHERE KOD_METER=? "
            . "AND DATE_BIL=?",[$billing,$meter,$date]);