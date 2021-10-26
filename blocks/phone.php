<?php
if (isset($_GET['param'])){
	$param = explode("-",$_GET['param']);
	if (!empty($param[0])) {
        $ID = $param[0];
    }
}
$dbPDO->execute("
SELECT u.ID, 
        phone_name as Модель,
        cp.company_name as 'Производитель',
        ORIG_IMAGE as image,
        concat (cn.company_name, ' ', cpu_name) as 'Процессор',
        concat(rm.sizes, rm.bytes) as 'Оперативная память',
        concat(rf.sizes, rf.bytes) as 'Внутренняя память',
        concat(display, '\"') as 'Диагональ', 
        concat (r.Width , 'x' , r.Heigth ,  ' (' , r.format_name , ')') as 'Разрешение дисплея' , 
        camera_front as 'Основная камера',
        camera_rear 'Селфи-камера',
        if(scanner,'есть','нет') 'Сканер отпечатка',
        concat(battery, 'mAh') Батарея,
        ANTUTU 'ANTUTU',
        concat(weight, 'грамм') as 'Вес'
FROM m_phone as u INNER JOIN 
m_display_format as r ON u.display_pixel=r.ID INNER JOIN 
m_cpu as c ON u.kod_processor = c.id LEFT JOIN 
bd_gallery as g ON u.image = g.id INNER JOIN
m_company as cp ON u.kod_company= cp.id INNER JOIN
m_company as cn ON c.kod_company= cn.id INNER JOIN 
m_ram as rm ON u.RAM = rm.id INNER JOIN 
m_ram as rf ON u.FLASH = rf.id
WHERE u.id=$ID");	
$row  = $dbPDO->select();
$arr_count=count($row);
$arr_keys = array_keys($row);
for ($i=0; $i<$arr_count; $i++) {
    if ($arr_keys[$i] == "image") {
        $img = $row[$arr_keys[$i]];
    } else {
        $out[$arr_keys[$i]] = $row[$arr_keys[$i]];
    }
}
$site_name = $row["Производитель"]." ".$row["Модель"];
$smarty = new Smarty;
$smarty->assign('user_level',$user_level);
$smarty->assign('out',$out);
$smarty->assign('jout', json_encode($out));
$smarty->assign('img',$img);
$smarty->assign('ph_id',$ID);
$smarty_tpl = 'phone.tpl';