<?php 
getPost(array('sort' => 'SORT'
            ,'by'=>'BY'
            ,'lim1'=>'STR'));
if ($lim1=='null') {
   $lim1   =0; 
}
$lim1 = (int)$lim1 * 25;
if ($sort=='null') {
   $sort   ="ASC"; 
}
if ($by=='null') {
   $by   ="1"; 
}
$dbPDO->execute("SELECT count(*) as cnt FROM m_phone");
$row  = $dbPDO->select();
$cnt = $row['cnt']/25;
		
//компании
$dbPDO->execute(
          "SELECT id, company_name n "
        . "FROM m_company "
        . "ORDER BY n");
	while ($row  = $dbPDO->select()) {
		$company []= $row;}
// пиксели камер               
$dbPDO->execute(
          "SELECT id, concat(round(pixel/1000000,1), 'Mpx') n "
        . "FROM m_camera "
        . "ORDER BY pixel");
	while ($row  = $dbPDO->select()) {
		$pixel []= $row;}
                
$dbPDO->execute("SELECT m_cpu.id, concat(cn.company_name, ' ', m_cpu.cpu_name) as n "
        . "FROM m_cpu INNER JOIN "
        . "     m_company as cn ON m_cpu.kod_company= cn.id "
        . "ORDER BY n");
	while ($row  = $dbPDO->select()) {
		$cpu []= $row;}
                
$dbPDO->execute(
        "SELECT id, concat(Width , 'x' , Heigth ,  ' (' , format_name , ')') as n "
        . "FROM m_display_format "
        . "ORDER BY Width");
	while ($row  = $dbPDO->select()) {
		$display_format_select []= $row;}
$dbPDO->execute(
         "SELECT id, concat(sizes ,  bytes ) as n "
        . "FROM m_ram "
        . "ORDER BY sizes");
	while ($row  = $dbPDO->select()) {
		$ram_select []= $row;}
                
$dbPDO->execute(
        "SELECT p.id"
    //    . ", p.kod_company ref_company"
        . ", phone_name name"
        . ", c.company_name company"
    //    . ", kod_processor ref_processor"
        . ", concat(cn.company_name, ' ', cpu_name) processor"
        . ", display_pixel ref_display_pixel"
        . ", concat (Width , 'x' , Heigth ,' (' , format_name , ')') as display"
        . ", display \"display-width\""
    //    . ", RAM ref_ram"
        . ", concat (r.sizes ,r.bytes ) as ram"
    //    . ", FLASH ref_flash"
        . ", concat (f.sizes ,f.bytes ) as flash"
        . ", (SELECT concat(round(pixel/1000000,1), 'Mpx') FROM m_camera WHERE id = p.camera_front) frontcamera"
        . ", (SELECT concat(round(pixel/1000000,1), 'Mpx') FROM m_camera WHERE id = p.camera_rear) rearcamera"
        . ", scanner"
        . ", battery"
        . ", ANTUTU antutu"
        . ", weight "
        . "FROM m_phone p LEFT JOIN "
        . "     m_company c ON p.kod_company = c.id LEFT JOIN "
        . "     m_cpu ON p.kod_processor = m_cpu.id LEFT JOIN "
        . "     m_company cn ON m_cpu.kod_company= cn.id LEFT JOIN "
        . "     m_display_format df ON p.display_pixel = df.id LEFT JOIN "
        . "     m_ram r ON p.RAM = r.id LEFT JOIN "
        . "     m_ram f ON p.FLASH = f.id "
        . "ORDER BY $by $sort LIMIT $lim1, 25");
while ($row  = $dbPDO->select()) {
        $phones[] =$row;
}

$smartyTmp = [ 'phones' => json_encode($phones),
            'company' => json_encode($company),
            'pixel' => json_encode($pixel),
            'cpu' => json_encode($cpu),
            'display' => json_encode($display_format_select),
            'ram' => json_encode($ram_select),
            'cnt' => $cnt,
            'val' => json_encode(["id" => "ID",
                                    "name" => "Мoдель",
                                    "company" => "Фирма",
                                    "processor" => "Процессор",
                                    "display" => "Разрешение дисплея",
                                    "display-width" => "Размер дисплея",
                                    "ram" => "ОЗУ",
                                    "flash" => "ПЗУ",
                                    "frontcamera" => "Камера",
                                    "rearcamera" => "Селфи камера",
                                    "scanner" => "Сканер",
                                    "battery" => "Аккум",
                                    "antutu" => "Тест ANTUTU",
                                    "weight" => "Вес"])];
$smarty_tpl = 'phone_list.tpl';

	