<?php

getPost(array('ID'=>'ID'
        ,'FAMILY'=>'FAMILY'
        ,'NAME'=>'NAME'
        ,'SURNAME'=>'SURNAME'
        ,'ip'=>'ip'
        ,'browser'=>'Браузер'
        ,'email'=>'email'
        ,'debug'=>'debug'
        ,'timezone'=>'timezone'));
    if ($debug === 'null') {
    $debug = '0';
}else if($debug === 'true'){
   $debug = '1'; 
}else if($debug === 'false'){
   $debug = '0'; 
}
if ($dbPDO->execute(
                "UPDATE bd_users "
                . "SET FAMILY='$FAMILY'"
                . ",NAME='$NAME'"
                . ",SURNAME='$SURNAME'"
                . ",timezone='$timezone'"
                . ",debug='$debug'"
                . ",ip='$ip'"
                . ",user_agent='$browser'"
                . ",email='$email' "
                . "WHERE ID=$ID "
                . " AND (USER_NAME='$login' "
                . " AND PASS='$password' "
                . " AND SESSEION_HASH ='$hash_user' "
                . " OR KOD_RANK > $user_level)")) {
    echo "Сохранение успешно";
}

setcookie("DEBUGON", $debug_on, time()+36000, "/");