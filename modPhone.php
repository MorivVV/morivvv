<?php
if ($user_autorization) {

		$id   = addslashes( trim($_POST['id']) );
				
		if (isset($_POST['kod_company']))
			$kod_company   = addslashes( trim($_POST['kod_company']) );
		else
			$kod_company = 'null';
		
		if (isset($_POST['kod_processor']))
			$kod_processor   = addslashes( trim($_POST['kod_processor']) );
		else
			$kod_processor = 'null';
		
		if (isset($_POST['display_pixel']))
			$display_pixel   = addslashes( trim($_POST['display_pixel']) );
		else
			$display_pixel = 'null';
		
		if (isset($_POST['display']))
			$display   = addslashes( trim($_POST['display']) );
		else
			$display = 'null';
		
		if (isset($_POST['ram']))
			$ram   = addslashes( trim($_POST['ram']) );
		else
			$ram = 'null';
		
		if (isset($_POST['flash']))
			$flash   = addslashes( trim($_POST['flash']) );
		else
			$flash = 'null';
		
		if (isset($_POST['camera_front']))
			$camera_front   = addslashes( trim($_POST['camera_front']) );
		else
			$camera_front = 'null';
		
		if (isset($_POST['camera_rear']))
			$camera_rear   = addslashes( trim($_POST['camera_rear']) );
		else
			$camera_rear = 'null';
		
		if (isset($_POST['scanner']))
			$scanner   = addslashes( trim($_POST['scanner']) );
		else
			$scanner = '0';
		
		if (isset($_POST['battery']))
			$battery   = addslashes( trim($_POST['battery']) );
		else
			$battery = 'null';
		
		if (isset($_POST['ANTUTU']))
			$ANTUTU   = addslashes( trim($_POST['ANTUTU']) );
		else
			$ANTUTU = 'null';
		
		if (isset($_POST['weight']))
			$weight   = addslashes( trim($_POST['weight']) );
		else
			$weight = 'null';
		
		$result =$dbPDO->execute("UPDATE m_phone 
			SET kod_company=$kod_company,
				kod_processor=$kod_processor,
				display_pixel=$display_pixel,
				display=$display,
				ram=$ram,
				flash=$flash,
				camera_front=$camera_front,
				camera_rear=$camera_rear,
			    scanner=$scanner,
			    battery=$battery,
			    ANTUTU=$ANTUTU,
			    weight=$weight
			WHERE ID=$id");
	//echo $sql;
	if ($result) 
	  ErrLog("Изменения внесены");
	else
	  ErrLog("Ошибка в запросе");
}
include "db/return.php";
?>
