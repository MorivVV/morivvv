<?php

$smile_name = $_POST['name'];
$smiles_page = $_POST['page'];
$next = false;
$outsmile = 50; //количество выводимых смайлов

if ($smile_name == "tumbs") {
    $dbPDO->execute("SELECT g.tumbs "
            . "FROM bd_gallery g INNER JOIN "
            . "     bd_gallery_access ga ON g.id = ga.kod_gallery INNER JOIN "
            . "     bd_users u ON ga.KOD_USER = u.ID "
            . "WHERE u.USER_NAME='$login' "
            . "  AND u.PASS='$password' "
            . "  AND u.SESSEION_HASH ='$hash_user' "
            . "ORDER BY ga.ID DESC "
            . "LIMIT $smiles_page, $outsmile");
    while ($row = $dbPDO->select()) {
        $smlist[] = $row['tumbs'];
    }
} else {
    $smlist = scandir(ROOT_DIRECTORY."/image/$smile_name");
    $smlist = excess(ROOT_DIRECTORY."/image/$smile_name", $smlist);
    sort($smlist, SORT_NUMERIC);
    $smlist = array_splice($smlist, $smiles_page, $outsmile);
}
$smartyTmp['smlist'] = json_encode($smlist);
$smarty_tpl ='ajax/getsmile.tpl';

