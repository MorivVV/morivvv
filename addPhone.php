<?php
getPost(array('phone_name'=>'phone_name'
        ,'kod_company'=>'kod_company'
        ,'kod_processor'=>'kod_processor'
        ,'display_pixel'=>'display_pixel'
        ,'display'=>'display'
        ,'ram'=>'ram'
        ,'flash'=>'flash'
        ,'weight'=>'weight'
        ,'ANTUTU'=>'ANTUTU'
        ,'battery'=>'battery'
        ,'scanner'=>'scanner'
        ,'camera_rear'=>'camera_rear'
        ,'camera_front'=>'camera_front'));
if ($user_autorization) {
    $dbPDO->execute(
"INSERT INTO m_phone (phone_name"
                . ",kod_company"
                . ",kod_processor"
                . ",display_pixel"
                . ",display"
                . ",ram"
                . ",flash"
                . ",camera_front"
                . ",camera_rear"
                . ",scanner"
                . ",battery"
                . ",ANTUTU"
                . ",weight) "
 . "VALUES ('$phone_name'"
        . ",$kod_company"
        . ",$kod_processor"
        . ",$display_pixel"
        . ",$display"
        . ",$ram"
        . ",$flash"
        . ",$camera_front"
        . ",$camera_rear"
        . ",$scanner"
        . ",$battery"
        . ",$ANTUTU"
        . ",$weight)");
} else {
    ErrLog("Вы не авторизованы");
}
include "db/return.php";
