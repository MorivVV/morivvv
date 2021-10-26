<?php
if (!isset($_GET['SQL'])) exit;
require_once ('../common.php'); //содержит все дефайны
include_once DB;
$dbPDO->execute(trim($_GET['SQL']));
echo $sql;
?>