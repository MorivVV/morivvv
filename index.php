<?php

ob_start();
error_reporting(E_ALL);
require_once ('common.php'); //содержит все дефайны
require_once(SMARTY_DIR . 'Smarty.class.php');

include "header.php";

include $url;

include "footer.php";
ob_end_flush();