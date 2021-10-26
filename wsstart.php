<?php
require_once('common.php');
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {  //Действия под виндой
    pclose(popen("start /B E:\OSPanel\modules\php\PHP_7.1-x64\php.exe -q " . ROOT_DIRECTORY . "\ws.php", "r"));
    ErrLog("start /B E:\OSPanel\modules\php\PHP_7.1-x64\php.exe -q " . ROOT_DIRECTORY . "\ws.php");
} else { 
    exec("php ".ROOT_DIRECTORY."/ws.php start");
    ErrLog("php ".ROOT_DIRECTORY."/ws.php start");
}