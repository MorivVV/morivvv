<?php 
setcookie("USER" , "", time() - 3600, "/");
setcookie("PASS" , "", time() - 3600, "/");	
setcookie("HASHIP" , "", time() - 3600, "/");
include "db/return.php";	
ErrLog("Вы вышли");
