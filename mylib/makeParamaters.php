<?php
function getParam($pArrs,$prm){
    if (!isset($prm)) {
        return 0;
    }
    $cnt = 0;
	$param = explode("-",$prm);
	foreach ($pArrs as $pArr) {
		global ${$pArr};
		if (!empty($param[$cnt])) {
                    ${$pArr} = $param[$cnt];
                    //ErrLog("$pArr =".$param[$cnt]);
                }
        $cnt++;
	}
	
}
function getPost($params) {
    global $_POST;
    foreach ($params as $key => $value) {
        global ${$key};
        if (!empty($_POST[$value])) {
            ${$key} = addslashes( trim($_POST[$value]));
        }
        else {
            ${$key} = 'null';
        }
    }
    
}

function searchFile ($url){
    $dir = array('blocks/','ajax/','');
    foreach ($dir as $value) {
        if (file_exists($value.$url.".php")) return $value.$url.".php";
    }
    return "404.php";
}