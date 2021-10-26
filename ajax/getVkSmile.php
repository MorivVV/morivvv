<?php
$i=0;
$beg = 97;
$end = 128;
$vkFolder = '';
getParam(array('vkFolder','beg','end'),$_GET['param']);
if ($vkFolder =='null') return;
if(!is_dir(ROOT_DIRECTORY."/image/$vkFolder/")) {
    mkdir(ROOT_DIRECTORY."/image/$vkFolder/", 0777, true);
}
for ($c = $beg; $c <= $end; $c++) {
    $i++;
    $file = "vk.com/images/stickers/$c/64.png";
    $newfile = ROOT_DIRECTORY."/image/$vkFolder/$i.png";
   
    $userAgent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/53";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $file);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    //curl_setopt($ch, CURLOPT_REFER, 'http://www.google.com');
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    $output = curl_exec($ch);
    $fh = fopen($newfile, 'w');
    fwrite($fh, $output);
    fclose($fh);
    
    ErrLog("$file -> $newfile");
}
$dbPDO->execute("INSERT INTO `admin_bbcode` (`bbID`, `onclick`, `ICON`, `USE`, `TITLE`, `ORD`) "
        . "VALUES ('$vkFolder', 'loadSmile(this)', '/image/$vkFolder/1.png', 1, '$vkFolder', 120)");