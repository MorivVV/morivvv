<?php 
if ($_SERVER['SERVER_NAME'] === "morivvv.byethost32.com") {
    $incl = "byethost.php";
}elseif ($_SERVER['SERVER_NAME'] === "morivvv.ru") {
    $incl = "fornex.php";
} else {
    $incl = "localhost.php";
}
//$incl = "fornex.php";
include_once 'databasePDO.php';

$debug_on=0;
if (isset($_COOKIE['DEBUGON'])) {
    $debug_on = trim($_COOKIE['DEBUGON']);
}

$dbPDO = new Database($incl,$debug_on);

function ErrLog ($errtext, $color='blue'){
    global $error_log;
    $error_log .="<p style='color: $color;'>$errtext</p>";  
}