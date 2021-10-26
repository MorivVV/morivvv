<?php
$rem = array("Никнейм", "Фамилия", "Имя", "Пароль", "Еще раз пароль",'<img src="kcaptcha/index.php?'.session_name().'='.session_id().'">',"Код с картинки");
$type = array("text", "text", "text", "password", "password", "text","submit");
$name = array("login", "family", "name", "password", "password2", "capcha","");
for ($i=0;$i<count($rem);$i++) {
	$datareg[] = array("rem" => $rem[$i],
					   "type" => $type[$i],
					   "name" => $name[$i]);
}
$smarty = new Smarty;
$smarty->assign('datareg',$datareg);
$smarty_tpl = 'register.tpl';
?>