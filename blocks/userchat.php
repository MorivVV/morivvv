<?php
$chat=1;
getParam(array('chat'), $_GET['param']);
$smarty = new Smarty;
$smarty->assign('chat',$chat);
$smarty_tpl = 'userchat.tpl';
