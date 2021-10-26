<?php

function excess($dir, $files) {/* Функция для удаления лишних файлов: сюда, помимо удаления текущей и родительской директории, так же можно добавить файлы, не являющиеся картинкой (проверяя расширение) */
    $result = array();
    for ($i = 0; $i < count($files); $i++) {
        if ($files[$i] != "." && $files[$i] != ".." && !is_dir($dir . '/' . $files[$i]))
            $result[] = $files[$i];
    }
    return $result;
}

function GetBBcode() {
    global $bbcode;
    global $htmlcode;
    global $smiles;
    global $dbPDO;
    $dbPDO->execute("SELECT bbID, BB_CODE, BB_CODE_END, onclick, HTML_CODE, HTML_CODE_END, ICON, TITLE, `USE` "
            . "FROM admin_bbcode "
            . "WHERE `USE` = 1 "
            . "ORDER BY ORD");
    while ($row = $dbPDO->select()) {
        $bbcode[] = $row["BB_CODE"];
        $bbcode[] = $row["BB_CODE_END"];
        $htmlcode[] = $row["HTML_CODE"];
        $htmlcode[] = $row["HTML_CODE_END"];
        if ($row["USE"]) {
            $smiles .= bbSmile($row);
        }
    }
}

function bbSmile($row) {
    $str = "<img ";
    if ($row["bbID"] !== ''){
        $str .= "id='" . $row["bbID"] . "' ";
        $str .= "@click='setSmile(\$event)' ";
        $str .= "name='0' ";
    }else {
        $str .= "name='textstyle' ";
        $str .= "onclick='" . $row["onclick"] . "' ";
    }      
    //
    $str .= "src='" . $row["ICON"] . "' ";
    $str .= "title='" . $row["TITLE"] . "' ";
    if ($row["BB_CODE"] !== '')
        $str .= "alt='" . $row["BB_CODE"] . $row["BB_CODE_END"] . "'>\n";
    return $str;
}

function postSmile($post) {
    global $bbcode;
    global $htmlcode;
    $temp = $post;

    //$temp = str_replace($bbcode, $htmlcode, $temp);
    //замены всех смайликов в тексте
    //$temp = preg_replace("<\*([a-zA-Z]+)(\d+)([a-zA-Z]+)\*>", "<img style='max-height: 64px;' src='/image/$1/$2.$3'>", $temp);
    //форматирование текста
    //$temp = preg_replace("<\[([\w-]+)=([#\d\w-]+)\]>", '<span style="$1: $2">', $temp);
    //замена ссылок
    //$temp = preg_replace('<\[URL=([^"^\]]+)\]([^\[]+)>', '<a target="_blank" href="$1">$2', $temp);
    //$temp = str_replace("[/color]", "</span>", $temp);
    return $temp;
}

$smiles = "<ldsml :smile_name=\"smilename\" smiles_page=\"0\"></ldsml>
			<div id='bbsml'>";
GetBBcode();
$smiles .= "</div>";
