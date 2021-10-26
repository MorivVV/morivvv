<?php

if ($user_level > 1) {
    ErrLog("Недостаточно прав доступа");
    return;
}
$smarty = new Smarty;
$dbPDO->execute("SHOW TABLES");
$table = "";
$col = $j = $c = 0;
$edt = false;
$tableList = array();
$headtable = $raw_query = array();
while ($row  = $dbPDO->selectNum()) {
    $tableList []=$row[0];
}
foreach ($tableList as $value) {
    $dbPDO->execute("SHOW COLUMNS FROM `$value`");
    $sel = '';
    $primkey = 'ID';
    $alias = '`' . chr(intdiv($c, 25) + 65) . chr(($c % 25) + 65) . '`';
    while ($row  = $dbPDO->selectNum()) {
        $sel .= $alias . '.`' . $row[0] . '`'
                . ', ';
        if ($row[3] == 'PRI')
            $primkey = $row[0];
    }
    $sel = substr($sel, 0, -2);
    $show_tables[$value] = array('table' => $value, 'sel' => $sel, 'alias' => $alias, 'pri' => $primkey);
    $c++;
    $col++;
}
$sql ="";
if (!isset($_POST['SQL'])) {
    goto exits;
}

$sql = trim($_POST['SQL']);
$edt = !strpos($sql, "HOW COLUMNS FROM");
$dbPDO->execute($sql);
//$col = 0 + mysqli_num_rows($result);
$table = trim(substr($sql, stripos($sql, "from") + 4));
if (stripos($table, " "))
    $table = trim(substr($table, 0, stripos($table, " ")));
while ($row  = $dbPDO->select()) {
    $raw_query[] = $row;
    if ($j == 0)
        $headtable = array_keys($row);
    $j++;
}
exits:
if (isset($_POST['table']) && ($_POST['table'] != "")) {
    $table_save = $_POST['table'];
    $smarty->assign('table_save', $table_save);
}
$smarty->assign('show_tables', $show_tables);
$smarty->assign('sql', $sql);
$smarty->assign('col', $col);
$smarty->assign('edt', $edt);
$smarty->assign('table', $table);
$smarty->assign('headtable', $headtable);
$smarty->assign('raw_query', $raw_query);
$smarty_tpl = 'typeSQL.tpl';