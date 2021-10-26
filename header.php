<?php
// Назначение: заголовочный файл для моего сайта .
// Дата: 16 мая 2016 г.
session_start();
$site_name = "Hello World";
$site_email= "morivvv@gmail.com";
$site_path = "/";
$error_log="";
$pageFolder = '';
$headerView = true;
include_once DB;
include "system/chek_user.php";
include "system/use_site.php";
include "mylib/makeParamaters.php";
include "system/private_message.php";

$url = "register";
if ($user_autorization) {
    $url = "theme_trep";
}
if (isset($_GET['url'])) {
    $url = $_GET['url'];
}
if (isset($_GET['hf'])) {
    $headerView = false;
}
if (isset($_GET['pagefolder'])) {
    $pageFolder = $_GET['pagefolder'];
}

if (isset($_GET['url'])){
    
	$get_url = addslashes($_GET['url']);
	$dbPDO->execute("SELECT url_name, url_mod FROM bd_url WHERE url=?",[$get_url] );	
	$row  = $dbPDO->select();
	$site_name = $row['url_name'];	
	if ($row['url_mod']) $url = $row['url_mod'];	
}

$url = searchFile($url);
$dbPDO->execute("SELECT url_name FROM bd_url WHERE id=1");
	$row  = $dbPDO->select();
	$site_rem = $row['url_name'];
$dbPDO->execute("SELECT u.url_name, u.url, u.kod_url, u.id  "
        . "FROM  bd_url u LEFT JOIN "
        . "      bd_url u2 ON u.kod_url = u2.id "
        . "WHERE u.LEVEL is Null OR u.LEVEL>=? " 
        . "ORDER BY u.ORD",[$user_level]);
while ($row = $dbPDO->select()) {
    $url_list[] = $row;
}
$smarty_header = new Smarty;
$smarty_header->assign('user_autorization',$user_autorization);
if ($user_autorization){
	$smarty_header->assign('profile_image',$profile_image);
	$smarty_header->assign('user',$_COOKIE["USER"]);}
$smarty_header->assign('user_id',$user_id);
$smarty_header->assign('url_list',json_encode($url_list));
$smarty_header->assign('countmessage',$countmessage);
if (isset($pr_msg)) $smarty_header->assign('pr_msg', $pr_msg);
$smarty_header->assign('site_rem',$site_rem);
$smarty_header->assign('addr',$_SERVER['REMOTE_ADDR']);